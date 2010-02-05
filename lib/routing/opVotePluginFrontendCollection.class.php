<?php

class opVotePluginFrontendRouteCollection extends sfRouteCollection
{
  public function __construct(array $options)
  {
    parent::__construct($options);

    $this->routes = array(
      'vote_list' => new sfRequestRoute(
        '/vote',
        array('module' => 'vote', 'action' => 'index'),
        array('sf_method' => array('get'))
      ),
      'vote_new' => new sfRequestRoute(
        '/vote/new',
        array('module' => 'vote', 'action' => 'new'),
        array('sf_method' => array('get'))
      ),
      'vote_create' => new sfRequestRoute(
        '/vote/create',
        array('module' => 'vote', 'action' => 'create'),
        array('sf_method' => array('post'))
      ),
      'vote_edit' => new sfDoctrineRoute(
        '/vote/edit/:id',
        array('module' => 'vote', 'action' => 'edit'),
        array('id' => '\d+', 'sf_method' => array('get')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      'vote_update' => new sfDoctrineRoute(
        '/vote/update/:id',
        array('module' => 'vote', 'action' => 'update'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      'vote_show' => new sfDoctrineRoute(
        '/vote/show/:id',
        array('module' => 'vote', 'action' => 'show'),
        array('id' => '\d+', 'sf_method' => array('get')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      'vote_post' => new sfDoctrineRoute(
        '/vote/post/:id',
        array('module' => 'vote', 'action' => 'post'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      'vote_delete_confirm' => new sfDoctrineRoute(
        '/vote/delete/:id',
        array('module' => 'vote', 'action' => 'deleteConfirm'),
        array('id' => '\d+', 'sf_method' => array('get')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      'vote_delete' => new sfDoctrineRoute(
        '/vote/delete/:id',
        array('module' => 'vote', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'VoteQuestion', 'type' => 'object')
      ),
      // no default
      'vote_nodefaults' => new sfRoute(
        '/vote/*',
        array('module' => 'default', 'action' => 'error')
      ),
    );
  }
}
