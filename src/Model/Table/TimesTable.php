<?php
namespace App\Model\Table;

use App\Model\Entity\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DateTime;

/**
 * Times Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Groups
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 */
class TimesTable extends Table
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

        $this->table('times');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('time_in', 'create')
            ->notEmpty('time_in');

        $validator
            ->requirePresence('time_out', 'create')
            ->notEmpty('time_out');

        $validator
            ->allowEmpty('activity');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        return $rules;
    }
	
	/**
	 * Retrieve time records based upon user and timeframe
	 * 
	 * Requires the pass of the request as the options element
	 * pass_params[0] is the number of days to return
	 * pass_params[1] is the user, or ALL for all users
     * 
     * If there is an Auth user, and no user param is passed, 
     * the Auth user is used
	 * 
	 * @param Query $query
	 * @param array $options
	 * @return Query
	 */
	public function findUserTimes(Query $query, array $options) {
        $session_user = $options['request']->session()->read('Auth.User.id');
        $default = [
            0 => 7,
            1 => is_null($session_user) ? 'ALL' : $session_user
        ];
        list($days, $user) = $options['request']->params['pass'] + $default;
                
		$query->order(['Times.time_in' => 'DESC']);
//        $query->contain(['Users', 'Projects']);
   		$query->where(['Times.time_in >=' => new DateTime("-180 days")]);

//        if($user != 'ALL'){
//			$query->where(['Times.user_id' => $user]);
//		}
        
        //This is the new shit, delte it
        
        $final_set = $query->filter(function($value, $key){
            return $value->duration > 8;
        });
        
//        \App\Lib\dmDebug::ddd($query->toArray());
        $final_set = $final_set->map(function($value, $key){
            $return = [];
            $return['durr'] = $value->duration;
            $return['id'] = $value->id;
            return $return;
        });
        $final_set = $final_set->sortBy('durr');
        \App\Lib\dmDebug::ddd($final_set->toArray());
        die;
        
        //end new shit

        return $query;
	}
	
}
