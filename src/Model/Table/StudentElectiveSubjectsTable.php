<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentElectiveSubjects Model
 *
 * @property \App\Model\Table\StudentInfosTable|\Cake\ORM\Association\BelongsTo $StudentInfos
 * @property \App\Model\Table\SubjectsTable|\Cake\ORM\Association\BelongsTo $Subjects
 * @property \App\Model\Table\SessionYearsTable|\Cake\ORM\Association\BelongsTo $SessionYears
 *
 * @method \App\Model\Entity\StudentElectiveSubject get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentElectiveSubject findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentElectiveSubjectsTable extends Table
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

        $this->setTable('student_elective_subjects');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('StudentInfos', [
            'foreignKey' => 'student_info_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Subjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SessionYears', [
            'foreignKey' => 'session_year_id',
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
        $rules->add($rules->existsIn(['student_info_id'], 'StudentInfos'));
        $rules->add($rules->existsIn(['subject_id'], 'Subjects'));
        $rules->add($rules->existsIn(['session_year_id'], 'SessionYears'));

        return $rules;
    }
}
