<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Atis;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Atis Model
 *
 * @property \App\Model\Table\AirportsTable&\Cake\ORM\Association\BelongsTo $Airports
 *
 * @method \App\Model\Entity\Atis newEmptyEntity()
 * @method \App\Model\Entity\Atis newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Atis[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Atis get($primaryKey, $options = [])
 * @method \App\Model\Entity\Atis findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Atis patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Atis[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Atis|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Atis saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Atis[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Atis[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Atis[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Atis[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AtisTable extends Table
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

        $this->setTable('atis');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->setEntityClass(Atis::class);

        $this->getSchema()->setColumnType('depature_runway', 'json');
        $this->getSchema()->setColumnType('arrival_runway', 'json');

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
            ->scalar('raw_atis')
            ->allowEmptyString('raw_atis');

        $validator
            ->scalar('atis_letter')
            ->maxLength('atis_letter', 255)
            ->allowEmptyString('atis_letter');

        $validator
            ->allowEmptyString('depature_runway');

        $validator
            ->allowEmptyString('arrival_runway');

        $validator
            ->scalar('transition_level')
            ->maxLength('transition_level', 255)
            ->allowEmptyString('transition_level');

        $validator
            ->dateTime('modifed')
            ->allowEmptyDateTime('modifed');

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
