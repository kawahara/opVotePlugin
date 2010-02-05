<?php

/**
 * PluginVoteQuestion form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginVoteQuestionForm extends BaseVoteQuestionForm
{
  public function setup()
  {
    // 親クラスのsetup()呼び出し
    parent::setup();

    // バリデータ書き換え
    $this->setValidator('title', new opValidatorString(array('max_length' => 140, 'trim' => true)));
    $this->setValidator('body', new opValidatorString(array('max_length' => 2147483647, 'trim' => true)));

    // 選択肢を指定するウィジェット追加
    $this->setWidget('option', new sfWidgetFormInput());
    $this->setValidator('option', new sfValidatorString(array('trim' => true)));
    $this->widgetSchema->setLabel('option', '選択肢');
    $this->widgetSchema->setHelp('option', '選択肢をスペース区切りで入力してください');

    // 編集時なら選択肢に現在のデータをデフォルトして挿入
    if (!$this->isNew())
    {
      $options = $this->getObject()->getVoteQuestionOptions()->toKeyValueArray('id', 'body');
      $this->setDefault('option', implode(' ', $options));
    }

    // 使うフィールド指定
    $this->useFields(array('title', 'body', 'option'));
  }

  protected function doSave($con = null)
  {
    parent::doSave();

    $newOptions = $this->getValue('option');
    $newOptions = preg_split('/[\s　]+/u', $newOptions, -1, PREG_SPLIT_NO_EMPTY);
    $voteQuestion = $this->getObject();

    // 過去の選択肢の抽出
    $oldOptions = $voteQuestion->getVoteQuestionOptions();
    $oldOptions = $oldOptions->toKeyValueArray('id', 'body');

    // 削除された選択肢の抽出
    $deletedOptions = array_diff($oldOptions, $newOptions);
    foreach ($deletedOptions as $id => $body)
    {
      // 削除
      $object = Doctrine::getTable('VoteQuestionOption')->find($id);
      $object->delete();
    }

    // 新規の選択肢
    $insertOptions = array_diff($newOptions, $oldOptions);
    foreach ($insertOptions as $body)
    {
      // 追加
      $object = new VoteQuestionOption();
      $object->setVoteQuestion($voteQuestion);
      $object->setBody($body);
      $object->save();
    }
  }
}
