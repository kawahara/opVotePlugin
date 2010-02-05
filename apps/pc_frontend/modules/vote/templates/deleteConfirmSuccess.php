<?php slot('body') ?>
<div>以下の質問を削除します。投票結果も削除されますがよろしいですか？</div>
<div><?php echo $question->getTitle() ?></div>
<?php end_slot() ?>

<?php op_include_yesno('delete_confirm', new BaseForm(), new BaseForm(array(), array(), false), array(
  'title' => '削除確認',
  'body' => get_slot('body'),
  'yes_url' => url_for('@vote_delete?id='.$question->getId()),
  'no_method' => 'get',
  'no_url' => url_for('@vote_show?id='.$question->getId()),
)) ?>
