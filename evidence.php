<?php

include("code/includes.php");

$active_user = new User();

if (array_key_exists('username', $_REQUEST)){
	$username = $_REQUEST['username'];
	$active_user->populateFromUsername($username);
}

echo '
<!DOCTYPE html><html><head><title>ACH: Help</title>';

include("parts/includes.php");

echo "<script src='js/tools.js'></script></head>";

include("parts/header.php"); 

if( $active_user->logged_in ) {
	include("parts/menu_sidebar.php");} 
else {
	include("parts/login_sidebar.php");
	echo '</div>';}

echo '
<div class="mainContainer">
<div class="ydsf left"><div class="inner">
<div class="help">
<div class="fontSize"><a href="javascript:changeFontSize(1)" style:font-size="14px">Enlarge font</a><br /><a href="javascript:changeFontSize(-1)" style:font-size="8px">Shrink font</a></p></div>

<h2>Evidence</h2> 
<p>As it does with each hypothesis, the ACH software creates a dedicated page for each item of evidence. This page includes details about the  evidence like the time of event and the type of source, and a section where members can discuss the evidence. New evidence items are added  via the <a href="howto_evidence.php">Enter Evidence/Arguments tool</a>.</p>

<h2>Choosing Evidence</h2>
<p>How do you choose your evidence? The word "evidence" is interpreted very broadly. It refers to all factors that influence your judgment about the  hypotheses. This includes assumptions and logical deductions as well as specific items of intelligence reporting. Assumptions or logical deductions  about capabilities, intentions, or how things normally work in the foreign country or culture involved are often more important than  hard evidence in determining analytical conclusions.</p>
<p>The absence of evidence is also evidence and must be noted. For example, if you are analyzing the intention of an adversary to launch  a military attack, the steps the adversary has not taken may be more significant than the observable steps that have been taken. Ask  yourself the following question for each hypothesis: If this hypothesis is true, what are all the things that must have happened, or  may still be happening, and what evidence of this should I expect to see? Then ask: If I am not seeing this evidence, why not? Is it  because it is not happening, it is being concealed, or because I have not looked for it?</p>
<p>Not all evidence needs to be included. For some types of issues, such as warning analysis, it may be useful to prune the older evidence.  A collection of older evidence is likely to bias the analysis in favor of concluding that the status quo will continue. If there is going  to be a significant change (such as a military attack, a coup d\'etat in the near future, or a surprising election victory or defeat) that  may well be apparent only from the recent evidence.</p>
<p>If you are uncertain whether an item of evidence is true or deceptive, it is often advisable to enter that evidence twice, once with the  assumption that it is not deceptive, and once with the assumption that it is deceptive. For example, a foreign leader makes a public statement of intentions, such as "we have no interest in developing weapons of mass destruction." You cannot rate the consistency or inconsistency  of that statement with your hypotheses without pre-judging whether the foreign leader is being truthful or trying to hide a weapons development  program. The solution is to enter and rate that item of evidence twice, once with the assumption that it is true, and once with the assumption it is deceptive. Entering this evidence twice with different consistency ratings forces you to think about the deception, and this is preferable to entering it only once and rating it as consistent with all hypotheses. In this case, you may also want to put a check in the flag column for  both entries to remind you that you have entered the same evidence item twice.</p>
<p>Have more questions about the Enter Evidence/Arguments page? We have <a href="howto_evidence.php">another help document</a> that explains how to use the page and what each field means.</p>
<p>Now that you have a matrix full of hypotheses and evidence, <a href="rate_consistency.php">the next step is to fill the matrix with consistency scores</a>.</p>
</div></div></div></div></div></div></div></div>';

include("parts/footer.php");

echo '</body></html>';
