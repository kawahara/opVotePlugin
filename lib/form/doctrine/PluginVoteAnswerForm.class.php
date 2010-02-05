<?php

/**
 * PluginVoteAnswer form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginVoteAnswerForm extends BaseVoteAnswerForm
{
  public function setup()
  {
    parent::setup();

    // 選択肢設定
    $voteQuestionOptions = $this->getObject()->getVoteQuestion()->getVoteQuestionOptions();
    $options = $voteQuestionOptions->toKeyValueArray('id', 'body');
    $this->setWidget('vote_question_option_id', new sfWidgetFormChoice(array('choices' => $options, 'expanded' => true)));
    $this->setValidator('vote_question_option_id', new sfValidatorChoice(array('choices' => array_keys($options))));
    $this->widgetSchema->setLabel('vote_question_option_id', '選択肢');

    // 使うフィールドを指定
    $this->useFields(array('vote_question_option_id'));
  }
}
