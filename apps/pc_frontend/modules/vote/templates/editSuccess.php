<?php op_include_form('vote_question_from', $form, array(
  'title' => '質問編集',
  'url' => url_for('@vote_update?id='.$form->getObject()->getId()),
)); ?>
