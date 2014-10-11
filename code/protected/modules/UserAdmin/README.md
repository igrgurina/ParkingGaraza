# UserAdmin module

Helps manage users, they roles and allowed tasks.

**Screenshots**

---

[![user list](http://i44.tinypic.com/2lw7u6c.png)](http://i39.tinypic.com/34y697p.png) [![user task details](http://i43.tinypic.com/2q2h45l.png)](http://i42.tinypic.com/9sqjd1.png) [![user details](http://i39.tinypic.com/2iutds2.png)](http://i40.tinypic.com/2hs50ld.png)

---

**Requriements:**
Twitter bootstrap 2.+

## Installation

#### 1) Extract and place

Probably you have folder in lowercase _useradmin_. Change it to _UserAdmin_
And place it in '/modules/'

#### 2) Database

Import **"UserAdmin/data/user_admin.sql"**

#### 3) Config file

```php

...
'import'=>array(
        ...
        'application.modules.UserAdmin.components.*',
        'application.modules.UserAdmin.models.*',
        ...
),
...
'modules'=>array(
        ...
        'UserAdmin',
        ...
),
'components'=>array(
        ...
        'user'=>array(
                'class'=>'UWebUser',
                'allowAutoLogin'=>true,
                'loginUrl'=>array('/UserAdmin/auth/login'),
        ),
        ...
)
...

```
You can also set cache expiration time (default is 3600)

```php

...
'modules'=>array(
       ...
       'UserAdmin' => array(
               'cache_time' => 3600,
       ),
       ...
),
...

```

#### 4) Extending base Controller

Extend your base "Controller" with "UAccessController"

```php

<?php
class Controller extends UAccessController
{
        ...
}

```


#### 4) Changing layout

In "UserAdmin/components/AdminDefaultController" change "public $layout" to your layout

#### 5) Links for CMenu

```php

//=========== Main controllers ===========

array('label'=>"Users", 'url'=>array('/UserAdmin/user/admin'), 'visible'=>User::checkTask('userAdmin')),
array('label'=>"Roles", 'url'=>array('/UserAdmin/userRole/admin'), 'visible'=>User::checkTask('userRoleAdmin')),
array('label'=>"Tasks", 'url'=>array('/UserAdmin/userTask/admin'), 'visible'=>User::checkRole('isSuperAdmin')),


//=========== Login, logout, registration, profile ===========

array('label'=>"Login", 'url'=>array('/UserAdmin/auth/login'), 'visible'=>!User::checkRole('isGuest')),
array('label'=>"Logout", 'url'=>array('/UserAdmin/auth/logout')),
array('label'=>"Registration", 'url'=>array('/UserAdmin/auth/registration'), 'visible'=>!User::checkRole('isGuest')),
array('label'=>"Profile", 'url'=>array('/UserAdmin/profile/personal'), 'visible'=>(!User::checkRole('isGuest') AND User::checkTask('personalProfileAccess'))),

```

#### 6) If you want to enable registration

Comment or delete **return false** in _'UserAdmin/controllers/AuthController'_ in _actionRegistration_ (line 69)


## Usage

To login use:
**superadmin/superadmin**
or
**admin/admin**

1) In order to make All controller actions available for everyone, add property

```php

public $freeAccess = true;

```


2) In order to make only some of the controller actions available for everyone, add property

```php

public $freeAccessActions = array('index', 'update', 'view');

```


3) If your controller extends some other controller and you want to set rules for parent controller actions,
you can add this property to you parent controller so all this actions will be availiable for moderation
in child controllers or add it to the child controller, so it will be availiable for moderation only there

```php

public $moderatedActions = array('index', 'update', 'view');

```


4) To check user's role, use  User::checkRole($roles, $superAdminHasAccess = true)

```php

User::checkRole('isSuperAdmin');
User::checkRole(array('reader', 'moderator', 'player'));  // You can specify array of roles

```


5) To check user's tasks, use  User::checkTask($task, $superAdminHasAccess = true)

```php

User::checkTask('editNews');

```


6) You can set backend home page for every role (except superadmin, since it's not actually a role).
User with this role will be redirected there after login or registration



7) To get current user model

```php

User::getCurrentUser();

```


8) To get array of user models for specified role

```php

User::getByRole('someRole');

```


9) To get current user backend home page

```php

User::getCurrentUserHomePage();

```


10) To get active users use scope active()

```php

User::model()->active()->findAll();

```

## Little candy in the end

There is a nice template controller _AdminDefaultController_ in the _'UserAdmin/components'_. 
