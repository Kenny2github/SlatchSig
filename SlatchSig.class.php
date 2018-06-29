<?php

class SlatchSig {
	// Register tag callbacks
	public static function onParserSetup( Parser $parser ) {
		// Set hook for "slatchsig" to renderTagSlatchSig
		$parser->setHook( 'slatchsig', 'SlatchSig::renderTagSlatchSig' );
	}
	// Render <slatchsig>
	public static function renderTagSlatchSig( $input, $args, $parser, $frame ) {
		$user = User::newFromName( $input );
		if ($user === false || $user->getId() === 0) {
			return htmlspecialchars(
				'<slatchsig>'
				. $input
				. '</slatchsig>'
			); // throw it back if user is invalid
		}
		$m = wfMessage( 'slatchsig-slatch' )->text();
		$o = '<br/><span style="color: blue">';
		for ($i = 0; $i < strlen($m); $i += 2) {
			$o .= '<sup>' . $m[$i] . '</sup>';
			$o .= '<sub>' . $m[$i+1] . '</sub>';
		}
		$o .= ' ';
		$o .= '<a href="'
			. $user->getUserPage()->getLocalURL()
			. '">'
			. $user->getName()
			. '</a>';
		$o .= ' ';
		$p = '';
		$p .= '<a href="'
			. $user->getTalkPage()->getLocalURL()
			. '">'
			. wfMessage( 'slatchsig-talk' )->text()
			. '</a>';
		$p .= wfMessage( 'pipe-separator' )->text();
		$p .= '<a href="'
			. SpecialPage::getTitleFor(
				'Contributions',
				$user->getName()
			)->getLocalURL()
			. '">'
			. wfMessage( 'slatchsig-contribs' )->text()
			. '</a>';
		$o .= wfMessage( 'parentheses', $p )->text();
		$o .= '</span>';
		return $o;
	}
}
