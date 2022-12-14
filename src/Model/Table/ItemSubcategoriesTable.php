<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemSubcategories Model
 *
 * @property \App\Model\Table\ItemCategoriesTable|\Cake\ORM\Association\BelongsTo $ItemCategories
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\ItemSubcategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemSubcategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemSubcategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubcategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemSubcategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemSubcategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubcategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubcategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemSubcategoriesTable extends Table
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

        $this->setTable('item_subcategories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ItemCategories', [
            'foreignKey' => 'item_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'item_subcategory_id'
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

       

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
        $rules->add($rules->existsIn(['item_category_id'], 'ItemCategories'));

        return $rules;
    }
}
