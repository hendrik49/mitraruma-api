<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ApplicatorService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var UserExtensionAttributeService
     */
    private $userExt;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @param  \App\Services\UserExtensionAttributeService  $userExt
     * @return void
     */
    public function __construct(
        UserService $user,
        UserExtensionAttributeService $userExt
    ) {
        $this->user = $user;
        $this->userExt = $userExt;
    }

    public function create($params){

        $user = $this->user->create($params);

        if($user['status'] == 201) {
            $userId = $user['data']['value']['ID'];
            foreach ($params['extension_attributes'] as $extension_attribute) {
                $extension_attribute['user_id'] = $userId;
                $this->userExt->create($extension_attribute);
            }
        }
        return $user;

    }
}