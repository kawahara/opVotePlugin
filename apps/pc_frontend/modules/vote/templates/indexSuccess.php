<?php op_include_box('vote_question_create_box', '選択肢つきの質問を作成することができます！', array(
  'title' => '質問作成',
  'moreInfo' => array(link_to('質問作成', '@vote_new'))
)); ?>


<?php if ($pager->getNbResults()): ?>

<?php slot('pager'); ?>
<?php op_include_pager_navigation($pager, '@vote_list?page=%d'); ?>
<?php end_slot() ?>

<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3>質問リスト</h3>
</div>
<?php include_slot('pager'); ?>
<?php foreach ($pager->getResults() as $item): ?>
<dl>
<dt><?php echo op_format_date($item->getUpdatedAt(), 'f') ?></dt>
<dd><?php echo link_to(sprintf("%s(%d)", $item->getTitle(), count($item->getVoteAnswers())), '@vote_show?id='.$item->getId()) ?></dd>
</dl>
<?php endforeach; ?>
<?php include_slot('pager'); ?>
</div>
</div>

<?php endif; ?>
