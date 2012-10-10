<?php
class ForumsModel extends PageModel
{
	/**
	 *  This is a plugin
	 */
	protected $plugin	= true;

	protected $tables	= array('Forums' => array('ForumCategories', 'ForumForums', 'ForumThreads', 'ForumPosts'));


	/************************************************** GET FUNCTIONS **************************************************/

	public function getMessageBBCodeIconBar($htmlMessageBoxId)
	{
		$box = '<a title="bold text" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\'[b]\',\'[/b]\');"><img class="bbCodeIcons" src="/plugins/Forums/img/text/bold.png" alt="bold" /></a>';
		$box.= '<a title="italic text" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\'[i]\',\'[/i]\');"><img class="bbCodeIcons" src="/plugins/Forums/img/text/italic.png" alt="italic" /></a>';
		$box.= '<a title="underlined text" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\'[u]\',\'[/u]\');"><img class="bbCodeIcons" src="/plugins/Forums/img/text/underline.png" alt="underline" /></a>';
		$box.= '<a title="striked through text" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\'[s]\',\'[/s]\');"><img class="bbCodeIcons" src="/plugins/Forums/img/text/strike.png" alt="strike through" /></a>';
		$box.= '<a title="insert link" onClick="document.getElementById(\''.$htmlMessageBoxId.'\').value+=add_link();"><img class="bbCodeIcons" src="/plugins/Forums/img/text/link.png" alt="link" /></a>';
		$box.= '<a title="insert picture" onClick="document.getElementById(\''.$htmlMessageBoxId.'\').value+=add_img();"><img class="bbCodeIcons" src="/plugins/Forums/img/text/image.png" alt="picture" /></a>';
		$box.= '<a title="insert code block" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\'[code]\',\'[/code]\');"><img class="bbCodeIcons" src="/plugins/Forums/img/text/code.png" alt="code block" /></a>';

		$box.= '<a style="float:left;">&nbsp;&nbsp;|&nbsp;&nbsp;</a>';

		$box.= '<a title="smile" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':)\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/smile.png" alt="smile" /></a>';
		$box.= '<a title="grin" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':D\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/grin.png" alt="grin" /></a>';
		$box.= '<a title="roll eyes" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':roll:\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/roll.png" alt="roll eyes" /></a>';
		$box.= '<a title="unhappy" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':(\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/unhappy.png" alt="unhappy" /></a>';
		$box.= '<a title="show tongue" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':p\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/tongue.png" alt="show tongue" /></a>';
		$box.= '<a title="cry" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':cry:\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/cry.png" alt="cry" /></a>';
		$box.= '<a title="blush" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':red:\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/red.png" alt="blush" /></a>';
		$box.= '<a title="confused" onClick="insertBBTag(\''.$htmlMessageBoxId.'\',\':confuse:\',\'\');"><img class="bbCodeIcons" src="/plugins/Forums/img/smiley/confuse.png" alt="confused" /></a>';
		return $box;
	}



	/**
	 *
	 * returns everything needed for the
	 * Forum index view
	 */
/*	public function getForum()
	{
		$categories = $this->ForumCategories->getAll(null, array('sort' => 'ASC'));

		for ($i=0; $i<sizeof($categories); $i++)
		{
			$cat_id = $categories[$i]['id'];
			$categories[$i]['forums'] = $this->ForumForums->getAllByCat($cat_id);
		}
		return $categories;
	}
*/
	/*
	public function getThreadWithUserInfo($thread_id)
	{
		$thread		= $this->ForumThreads->getRow($thread_id);
		$user_id	= $thread['fk_user_id'];

		$numPosts	= $this->ForumPosts->countUserPosts($user_id);
		$numThreads	= $this->ForumThreads->countUserThreads($user_id);

		$thread['num_entries']	= $numPosts+$numThreads;

		return $thread;
	}
	public function getPostsWithUserInfo($thread_id, $order = array('created' => 'ASC'))
	{
		$posts		= $this->ForumPosts->getPosts($thread_id, $order);
		$size		= sizeof($posts);

		for($i=0; $i<$size; $i++)
		{
			$user_id	= $posts[$i]['fk_user_id'];
			$numPosts	= $this->ForumPosts->countUserPosts($user_id);
			$numThreads	= $this->ForumThreads->countUserThreads($user_id);

			$posts[$i]['num_entries']	= $numPosts+$numThreads;
		}
		return $posts;
	}
*/
	/*
	public function getForumName($forum_id)
	{
		return $this->ForumForums->getName($forum_id);
	}
	public function getForumSeoUrl($forum_id)
	{
		return $this->ForumForums->getSeoUrl($forum_id);
	}
	public function getThreadSeoUrl($thread_id)
	{
		return $this->ForumThreads->getSeoUrl($thread_id);
	}
	public function getThreads($forum_id)
	{
		return $this->ForumThreads->getByForum($forum_id);

	}
	public function getThread($thread_id)
	{
		return $this->ForumThreads->getRow($thread_id);
	}
	public function getPost($post_id)
	{
		return $this->ForumPosts->getRow($post_id);
	}*/



	/************************************************** UPDATE FUNCTIONS **************************************************/

	public function updateThreadView($thread_id)
	{
		$this->ForumThreads->increment($thread_id, array('view_count'));
	}
	/************************************************** EXIST FUNCTIONS **************************************************/
	/*
	public function forumExists($forum_id)
	{
		return $this->ForumForums->rowExists($forum_id);
	}
	public function threadExists($thread_id)
	{
		return $this->ForumThreads->rowExists($thread_id);
	}
	public function postExists($post_id)
	{
		return $this->ForumPosts->rowExists($post_id);
	}*/
	/************************************************** CHECK FUNCTIONS **************************************************/
	public function isMyPost($post_id, $user_id)
	{
		return $this->ForumPosts->isMyPost($post_id, $user_id);
	}
	public function isMyThread($thread_id, $user_id)
	{
		return $this->ForumThreads->isMyThread($thread_id, $user_id);
	}
	/*
	public function forumOwnsThread($forum_id, $thread_id)
	{
		$condition = sprintf("id = %d AND fk_forum_forums_id = %d", $thread_id, $forum_id);
		return $this->ForumThreads->count($condition);
	}

	public function threadIsLocked($thread_id)
	{
		return $this->ForumThreads->getField($thread_id, 'is_locked');
	}
	public function threadIsClosed($thread_id)
	{
		return $this->ForumThreads->getField($thread_id, 'is_closed');
	}
*/
	/************************************************** SORT FUNCTIONS **************************************************/
/*
	public static function sortForumThreadsByLastEntry($a, $b)
	{
		$a_last_post	= trim($a['last_post_created']);
		$b_last_post	= trim($b['last_post_created']);

		$a_sticky		= $a['is_sticky'];
		$b_sticky		= $b['is_sticky'];

		if ( $a_sticky || $b_sticky )
			return ($a_sticky < $b_sticky);

		if ( strlen($a_last_post) == 0  )
			$a['last_post_created'] = $a['created'];

		if ( strlen($b_last_post) == 0  )
			$b['last_post_created'] = $b['created'];

		return ( $a['last_post_created'] < $b['last_post_created'] );
	}*/
}
