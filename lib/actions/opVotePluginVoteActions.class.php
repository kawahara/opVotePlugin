<?php

class opVotePluginVoteActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = Doctrine::getTable('VoteQuestion')->getListPager($request->getParameter('page'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new VoteQuestionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $object = new VoteQuestion();
    $object->setMember($this->getUser()->getMember());
    $this->form = new VoteQuestionForm($object);
    if ($this->form->bindAndSave($request->getParameter('vote_question')))
    {
      $this->redirect('@vote_show?id='.$this->form->getObject()->getId());
    }
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $this->forward404Unless($this->getUser()->getMemberId() == $object->getMemberId());
    $this->form = new VoteQuestionForm($object);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $this->forward404Unless($this->getUser()->getMemberId() == $object->getMemberId());
    $this->form = new VoteQuestionForm($object);
    if ($this->form->bindAndSave($request->getParameter('vote_question')))
    {
      $this->getUser()->setFlash('notice', '編集しました');
      $this->redirect('@vote_show?id='.$object->getId());
    }
    $this->setTemplate('edit');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->question = $this->getRoute()->getObject();

    // ログイン者の回答済み内容
    $yourAnswer = Doctrine::getTable('VoteAnswer')->findOneByMemberIdAndVoteQuestionId(
      $this->getUser()->getMemberId(),
      $this->question->getId()
    );

    if ($yourAnswer || $this->question->getMemberId() == $this->getUser()->getMemberId())
    {
      // 結果出力のためのデータ集計
      $answers = Doctrine::getTable('VoteAnswer')->findByVoteQuestionId($this->question->getId());
      $options = Doctrine::getTable('VoteQuestionOption')->findByVoteQuestionId($this->question->getId());
      $this->options = $options->toKeyValueArray('id', 'body');
      $this->answerTotal = array();
      $this->total = 0;
      foreach ($answers as $answer)
      {
        $this->total++;
        if (isset($this->answerTotal[$answer->getVoteQuestionOptionId()]))
        {
          $this->answerTotal[$answer->getVoteQuestionOptionId()]++;
        }
        else
        {
          $this->answerTotal[$answer->getVoteQuestionOptionId()] = 1;
        }
      }
      arsort($this->answerTotal);
    }
    else
    {
      // 回答済みでないかつ作成者でないときフォームオブジェクト作成
      $voteAnswer = new VoteAnswer();
      $voteAnswer->setVoteQuestion($this->question);
      $voteAnswer->setMember($this->getUser()->getMember());
      $this->form = new VoteAnswerForm($voteAnswer);
    }
  }

  public function executePost(sfWebRequest $request)
  {
    $question = $this->getRoute()->getObject();

    $yourAnswer = Doctrine::getTable('VoteAnswer')->findOneByMemberIdAndVoteQuestionId(
      $this->getUser()->getMemberId(),
      $question->getId()
    );

    // 回答済みであったり、作成者であった場合404
    $this->forward404If($yourAnswer || $question->getMemberId() == $this->getUser()->getMemberId());

    $voteAnswer = new VoteAnswer();
    $voteAnswer->setVoteQuestion($question);
    $voteAnswer->setMember($this->getUser()->getMember());
    $this->form = new VoteAnswerForm($voteAnswer);
    if ($this->form->bindAndSave($request->getParameter('vote_answer')))
    {
      $this->redirect('@vote_show?id='.$question->getId());
    }

    // 保存失敗のときは show のテンプレート使い回し
    $this->setTemplate('show');
  }

  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->question = $this->getRoute()->getObject();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->getRoute()->getObject()->delete();
    $this->getUser()->setFlash('notice', '削除しました');
    $this->redirect('@vote_list');
  }
}
