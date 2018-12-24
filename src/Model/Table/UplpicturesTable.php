<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;


/**
 * Processings Model
 *
 * @method \App\Model\Entity\Processing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Processing newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Processing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Processing|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Processing|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Processing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Processing[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Processing findOrCreate($search, callable $callback = null, $options = [])
 */
class UplpicturesTable extends Table
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

        $this->setTable('uplpictures');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }

    // テーブルクラスの中で
    public function buildRules(RulesChecker $rules)
    {

      $rules->add($rules->isUnique(['title']));

      return $rules;
    }
}
