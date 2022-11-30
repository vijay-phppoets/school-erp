<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DailyThoughts Model
 *
 * @method \App\Model\Entity\DailyThought get($primaryKey, $options = [])
 * @method \App\Model\Entity\DailyThought newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DailyThought[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DailyThought|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DailyThought|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DailyThought patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DailyThought[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DailyThought findOrCreate($search, callable $callback = null, $options = [])
 */
class DailyThoughtsTable extends Table
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

        $this->setTable('daily_thoughts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
			$this->belongsTo('Users');
		$this->belongsTo('Notifications');
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
/*
        $validator
            ->scalar('role_type')
            ->requirePresence('role_type', 'create')
            ->notEmpty('role_type');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->dateTime('edited_on')
            ->requirePresence('edited_on', 'create')
            ->notEmpty('edited_on');

        $validator
            ->integer('edited_by')
            ->requirePresence('edited_by', 'create')
            ->notEmpty('edited_by');

        $validator
            ->scalar('is_deleted')
            ->requirePresence('is_deleted', 'create')
            ->notEmpty('is_deleted');*/

        return $validator;
    }
}
