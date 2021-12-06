<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Airports Model
 *
 * @method \App\Model\Entity\Airport newEmptyEntity()
 * @method \App\Model\Entity\Airport newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Airport[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Airport get($primaryKey, $options = [])
 * @method \App\Model\Entity\Airport findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Airport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Airport[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Airport|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Airport saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Airport[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Airport[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Airport[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Airport[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AirportsTable extends Table
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

        $this->setTable('airports');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Organizations', [
            'foreignKey' => 'organization_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Atis', [
            'foreignKey' => 'airport_id',
        ]);
        $this->hasMany('Metar', [
            'foreignKey' => 'airport_id',
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
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('icao')
            ->maxLength('icao', 255)
            ->requirePresence('icao', 'create')
            ->notEmptyString('icao');

        $validator
            ->scalar('atis_callsign')
            ->maxLength('atis_callsign', 255)
            ->requirePresence('atis_callsign', 'create')
            ->notEmptyString('atis_callsign');

        $validator
            ->scalar('atis_depature_runway_pattern')
            ->maxLength('atis_depature_runway_pattern', 255)
            ->allowEmptyString('atis_depature_runway_pattern');

        $validator
            ->scalar('atis_arrival_runway_pattern')
            ->maxLength('atis_arrival_runway_pattern', 255)
            ->allowEmptyString('atis_arrival_runway_pattern');

        $validator
            ->scalar('atis_transition_level_pattern')
            ->maxLength('atis_transition_level_pattern', 255)
            ->allowEmptyString('atis_transition_level_pattern');

        $validator
            ->dateTime('closed_runways_timeout')
            ->allowEmptyDateTime('closed_runways_timeout');

        $validator
            ->dateTime('missed_approach_timeout')
            ->allowEmptyDateTime('missed_approach_timeout');

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
        $rules->add($rules->existsIn('organization_id', 'Organizations'), ['errorField' => 'organization_id']);

        return $rules;
    }
}
