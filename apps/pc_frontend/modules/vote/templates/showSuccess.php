<?php slot('question_body'); ?>
<h4 style="font-weight:bold;"><?php echo $question->getTitle(); ?></h4>
<?php if ($question->getMemberId() == $sf_user->getMemberId()): ?>
<div>
<?php echo link_to('[編集]', '@vote_edit?id='.$question->getId()) ?>&nbsp;
<?php echo link_to('[削除]', '@vote_delete_confirm?id='.$question->getId()) ?>
</div>
<?php endif; ?>
<div>質問者: <?php echo link_to($question->getMember()->getName(), '@obj_member_profile?id='.$question->getMemberId()); ?></div>
<div><?php echo nl2br($question->getBody()); ?></div>
<?php end_slot(); ?>
<?php op_include_box('vote_question', get_slot('question_body'), array(
  'title' => '質問'
)) ?>

<?php if (isset($form)): ?>

<?php op_include_form('vote_form', $form, array(
  'title' => '回答',
  'url' => url_for('@vote_post?id='.$question->getId())
)) ?>

<?php else: ?>

<?php slot('result_body'); ?>
<?php if (count($answerTotal)): ?>
<table>
<tbody>
<?php foreach ($answerTotal as $key => $t): ?>
<tr>
<th><?php echo $options[$key] ?></td>
<td><div style="width:<?php echo round($t / $total * 100) ?>%;background-color:#8888FF;">
<?php echo $t ?>票 (<?php echo round($t / $total * 100) ?>%)
</div></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
まだ投票がありません。
<?php endif; ?>
<?php end_slot(); ?>

<?php op_include_box('vote_result', get_slot('result_body'), array(
  'title' => '結果'
)); ?>
<?php endif; ?>
