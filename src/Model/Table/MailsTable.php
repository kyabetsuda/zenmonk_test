<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\Datasource\ConnectionManager;

/**
 * Mails Model
 *
 * @method \App\Model\Entity\Mail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mail findOrCreate($search, callable $callback = null, $options = [])
 */
class MailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('mails');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('title')
            ->maxLength('title', 1024)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->scalar('remote_address')
            ->maxLength('remote_address', 64)
            ->requirePresence('remote_address', 'create')
            ->notEmpty('remote_address');


        $validator
            ->dateTime('ins_ymd')
            ->requirePresence('ins_ymd', 'create')
            ->notEmpty('ins_ymd');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        // 作成および更新操作に提供されるルールを追加
        $rules->add(function($entity, $options){
          $today = date('Ymd');
          $tommorow = date('Ymd') + 1;
          $conn = ConnectionManager::get('default');
    			$stmt = $conn->prepare(
    	    	'select * from mails where remote_address = :remote_address and ins_ymd between :ins_ymd1 and :ins_ymd2'
    			);
    			$stmt->bindValue(':remote_address', $entity->remote_address);
          $stmt->bindValue(':ins_ymd1', $today);
          $stmt->bindValue(':ins_ymd2', $tommorow);
    			$stmt->execute();
    			$mails = $stmt->fetchAll('assoc');

          //メールを送信できるのは1日に5件まで
          if(count($mails) > 4){
            return false;
          }
          return true;
        }, 'ruleName');

        return $rules;
    }

}
