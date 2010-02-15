<?php

class opVotePlugin1_AddPublicFlagColumn extends Doctrine_Migration_Base
{
  public function migrate($direction)
  {
    $this->column($direction, 'vote_question', 'public_flag', 'integer', 1, array(
      'notnull' => true,
      'default' => 1
    ));
  }
}
