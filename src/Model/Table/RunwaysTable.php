<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Runways Model
 *
 * @property \App\Model\Table\AirportsTable&\Cake\ORM\Association\BelongsTo $Airports
 * @method \App\Model\Entity\Runway newEmptyEntity()
 * @method \App\Model\Entity\Runway newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Runway[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Runway get($primaryKey, $options = [])
 * @method \App\Model\Entity\Runway findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Runway patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Runway[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Runway|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Runway saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Runway[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Runway[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Runway[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Runway[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RunwaysTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('runways');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Airports', [
            'foreignKey' => 'airport_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('airport_id')
            ->requirePresence('airport_id', 'create')
            ->notEmptyString('airport_id');

        $validator
            ->scalar('designator')
            ->maxLength('designator', 255)
            ->requirePresence('designator', 'create')
            ->notEmptyString('designator');

        $validator
            ->boolean('closed')
            ->notEmptyString('closed');

        $validator
            ->integer('position_x')
            ->allowEmptyString('position_x');

        $validator
            ->integer('position_y')
            ->allowEmptyString('position_y');

        $validator
            ->integer('rotation')
            ->allowEmptyString('rotation');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('airport_id', 'Airports'), ['errorField' => 'airport_id']);

        return $rules;
    }
}
