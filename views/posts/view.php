<?php defined('__ROOT__') OR exit('No direct script access allowed'); ?>
<h1>Posts</h1>
<?php foreach ($this->data['allPosts'] as $post): ?>
	<h4><?php echo $post->author ?></h4>
<?php endforeach; ?>