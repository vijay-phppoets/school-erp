<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Holidays Model
 *
 * @property \App\Model\Table\HolidaysTable|\Cake\ORM\Association\BelongsTo $Holidays
 * @property \App\Model\Table\HolidaysTable|\Cake\ORM\Association\HasMany $Holidays
 *
 * @method \App\Model\Entity\Holiday get($primaryKey, $options = [])
 * @method \App\Model\Entity\Holiday newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Holiday[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Holiday|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Holiday|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Holiday patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Holiday[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Holiday findOrCreate($search, callable $callback = null, $options = [])
 */
class HolidaysTable extends Table
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

        $this->setTable('holidays');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Holidays', [
            //'foreignKey' => 'holiday_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Holidays', [
           // 'foreignKey' => 'holiday_id'
        ]);
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['holiday_id'], 'Holidays'));

        return $rules;
    }
}
