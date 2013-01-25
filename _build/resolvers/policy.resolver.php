<?php
 
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('yley.core_path',null,$modx->getOption('core_path').'components/yley/').'model/';
            $modx->addPackage('yley',$modelPath);

            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $LogTarget = $modx->getLogTarget();  
            $LogTopic = $LogTarget->subscriptions[0];
            $Errors = array();
            
            /*
             * Связываем шаблоны безопасности и роли
             */
            $policy = $transport->xpdo->getObject('modAccessPolicy',array(
                'name' => 'Yley Administrator'
            ));
            if ($policy) {
                $template = $transport->xpdo->getObject('modAccessPolicyTemplate',array('name' => 'Yley Policy Template'));
                if ($template) {
                    $policy->set('template',$template->get('id'));
                    $policy->save();
                } else {
                    $modx->log(xPDO::LOG_LEVEL_ERROR,'[Yley] Could not find QuipModeratorPolicyTemplate Access Policy Template!');
                }
            } else {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'[Yley] Could not find Yley AdministratorPolicy Access Policy!');
            }

            /*
             * Перестраиваем группы пользователей
             */
            
            $yley_group = $transport->xpdo->getObject('modUserGroup', array(
                'name'      => 'Yley',
            ));
            
            $yley_admin_group = $transport->xpdo->getObject('modUserGroup', array(
                'name'      => 'Yley Administrators',
            ));

            if($yley_group && $yley_admin_group){
                $yley_admin_group->set('parent', $yley_group->get('id'));
                $yley_admin_group->save();
            }
            
            
            /*
             * Устанавливаем ддоступы к контекстам
             */
            
            if(!$role = $transport->xpdo->getObject('modUserGroupRole', array(
                'name' => 'Yley Administrator'
            ))){
                $modx->log(xPDO::LOG_LEVEL_ERROR,'[Yley] Не была получена роль Администратора Улей');
            }
            
            $contexts = array('web', 'mgr');
            
            
            foreach($contexts as $context){
                
                
            
                $response = $transport->xpdo->runProcessor('security/access/addacl', array(
                    'target'            => $context,
                    'authority'         => $role->get('authority'),
                    'policy'            => $policy->id,
                    'principal'         => $yley_admin_group->id,
                    'principal_class'   =>  'modUserGroup',
                    'type'              =>  'modAccessContext',
                ));
                
                
                
                if($response->isError()){
                    $errors[] = '[Yley] Ошибка создания доступа к контексту: '. $response->getMessage();
                }
            }
            
            $modx->registry->setLogging($LogTarget, $LogTopic);
            
            if($errors){
                foreach($errors as $err){
                    $modx->log(xPDO::LOG_LEVEL_ERROR, $err);
                }
            }
            
            
            
            
            $modx->setLogLevel(modX::LOG_LEVEL_INFO); 
            
            break;
    }
}
return true;