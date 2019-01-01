<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;

/**
 * Pictures Model
 *
 * @method \App\Model\Entity\Picture get($primaryKey, $options = [])
 * @method \App\Model\Entity\Picture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Picture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Picture|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Picture|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Picture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Picture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Picture findOrCreate($search, callable $callback = null, $options = [])
 */
class PicturesTable extends Table
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

        $this->setTable('pictures');
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

        $validator
            ->dateTime('ins_ymd')
            ->requirePresence('ins_ymd', 'create')
            ->notEmpty('ins_ymd');

        $validator
            ->dateTime('upd_ymd')
            ->requirePresence('upd_ymd', 'create')
            ->notEmpty('upd_ymd');

        $validator
            ->dateTime('content')
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
        ->dateTime('contName')
        ->requirePresence('contName', 'create')
        ->notEmpty('contName');

        $validator
        ->dateTime('thumbnail')
        ->requirePresence('thumbnail', 'create')
        ->notEmpty('thumbnail');

        return $validator;
    }

    // テーブルクラスの中で
    public function buildRules(RulesChecker $rules)
    {

      return $rules;
    }
}
