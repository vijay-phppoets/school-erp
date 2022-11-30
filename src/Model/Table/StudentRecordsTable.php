<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentRecords Model
 *
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\StudentRecordsTable|\Cake\ORM\Association\BelongsTo $ParentStudentRecords
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property |\Cake\ORM\Association\BelongsTo $Streams
 * @property |\Cake\ORM\Association\BelongsTo $StudentClasses
 * @property \App\Model\Table\StudentRecordsTable|\Cake\ORM\Association\HasMany $ChildStudentRecords
 *
 * @method \App\Model\Entity\StudentRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentRecord newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudentRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentRecord|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentRecord|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentRecord[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentRecord findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentRecordsTable extends Table
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

        $this->setTable('student_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentStudentRecords', [
            'className' => 'StudentRecords',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Streams', [
            'foreignKey' => 'stream_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('StudentClasses', [
            'foreignKey' => 'student_class_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ChildStudentRecords', [
            'className' => 'StudentRecords',
            'foreignKey' => 'parent_id'
        ]);
		 $this->belongsTo('StudentInfos', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
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
            ->scalar('attend')
            ->maxLength('attend', 100)
            ->allowEmpty('attend');

        $validator
            ->scalar('meeting')
            ->maxLength('meeting', 100)
            ->allowEmpty('meeting');

        $validator
            ->scalar('marks')
            ->maxLength('marks', 100)
            ->allowEmpty('marks');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 100)
            ->allowEmpty('grade');

        $validator
            ->scalar('percentage')
            ->maxLength('percentage', 100)
            ->allowEmpty('percentage');

        $validator
            ->scalar('status')
            ->maxLength('status', 100)
            ->allowEmpty('status');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 100)
            ->allowEmpty('remark');

        $validator
            ->integer('marksmax')
            ->requirePresence('marksmax', 'create')
            ->notEmpty('marksmax');

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
        //$rules->add($rules->existsIn(['student_id'], 'Students'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentStudentRecords'));
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        $rules->add($rules->existsIn(['stream_id'], 'Streams'));
        $rules->add($rules->existsIn(['student_class_id'], 'StudentClasses'));

        return $rules;
    }
}
