<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Metar Model
 *
 * @method \App\Model\Entity\Metar newEmptyEntity()
 * @method \App\Model\Entity\Metar newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Metar[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Metar get($primaryKey, $options = [])
 * @method \App\Model\Entity\Metar findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Metar patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Metar[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Metar|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Metar saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Metar[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Metar[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Metar[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Metar[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MetarTable extends Table
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

        $this->setTable('metar');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->getSchema()->setColumnType('wind_shear_runways', 'json');
        $this->getSchema()->setColumnType('rvr', 'json');

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
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('raw_metar')
            ->requirePresence('raw_metar', 'create')
            ->notEmptyString('raw_metar');

        $validator
            ->integer('qnh_value')
            ->allowEmptyString('qnh_value');

        $validator
            ->scalar('qnh_unit')
            ->maxLength('qnh_unit', 255)
            ->allowEmptyString('qnh_unit');

        $validator
            ->scalar('qnh_trend')
            ->maxLength('qnh_trend', 255)
            ->allowEmptyString('qnh_trend');

        $validator
            ->integer('mean_direction')
            ->allowEmptyString('mean_direction');

        $validator
            ->allowEmptyString('is_variable');

        $validator
            ->integer('mean_speed')
            ->allowEmptyString('mean_speed');

        $validator
            ->integer('speed_variations')
            ->allowEmptyString('speed_variations');

        $validator
            ->allowEmptyString('rvr');

        $validator
            ->allowEmptyString('wind_shear_all_runways');

        $validator
            ->scalar('conditions')
            ->maxLength('conditions', 255)
            ->allowEmptyString('conditions');

        $validator
            ->allowEmptyString('rvr');

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
