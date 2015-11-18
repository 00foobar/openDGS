<?php
require_once('../../bootstrap.php');

$user = new User();

// checks if user is logged in and is a administrator
if ( !$user->isLoggedIn() || !$user->isAdmin() )
{
	// user is no admin or not logged in
	exit();
}

$faq = new FAQ();


// Add FAQ entry
if ( isset($_POST['new_faq_question']) && strlen($_POST['new_faq_question']) < 255 && isset($_POST['new_faq_answer']) )
{
	$question = strip_tags($_POST['new_faq_question']);
	$answer = strip_tags($_POST['new_faq_answer']);

	if ( $faq->addFAQ($question, $answer) )
	{
		echo json_encode(true);
		exit();
	}
}
// Delete FAQ entry
if ( isset($_POST['faq_id']) && is_numeric($_POST['faq_id']) && isset($_POST['faq_delete']) && $_POST['faq_delete'] == "1" )
{
	$faq_id = intval($_POST['faq_id']);

	if ( $faq->deleteFAQ($faq_id) )
	{
		echo json_encode(true);
		exit();
	}
}

// Edit FAQ entry
if ( isset($_POST['faq_question']) && strlen($_POST['faq_question']) < 255 && isset($_POST['faq_answer']) && isset($_POST['faq_id']) && is_numeric($_POST['faq_id']) )
{
	$faq_id = intval($_POST['faq_id']);
	$question = strip_tags($_POST['faq_question']);
	$answer = strip_tags($_POST['faq_answer']);

	if ( $faq->editFAQ($faq_id, $question, $answer) )
	{
		echo json_encode(true);
		exit();
	}
}

echo json_encode(false);
?>