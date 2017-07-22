<?php
	DEFINED("SPM_GENUINE") OR DIE('403 ACCESS DENIED');
	include(LOCALE . "news.php");
	
	isset($_GET['page']) or $_GET['page'] = 1;
	
	(int)$_GET['page']>0 or $_GET['page']=1;
	
	if (!$db_result = $db->query("SELECT count(id) FROM `spm_news`"))
		die(header('location: index.php?service=error&err=db_error'));
	
	$total_articles_number = (int)($db_result->fetch_array()[0]);
	$articles_per_page = $_SPM_CONF["SERVICES"]["news"]["articles_per_page"];
	$current_page = (int)$_GET['page'];
	
	$db_result->free();
	unset($db_result);
	
	if ($total_articles_number > 0 && $articles_per_page > 0)
		$total_pages = ceil($total_articles_number / $articles_per_page);
	else
		$total_pages = 1;
	
	if ($current_page > $total_pages)
		$current_page = 1;
	
	if (!$db_result = $db->query("SELECT * FROM `spm_news` ORDER BY `id` DESC LIMIT " . ($current_page * $articles_per_page - $articles_per_page) . " , " . $articles_per_page . ";"))
		die(header('location: index.php?service=error&err=db_error'));
	
	
	SPM_header("Новини", "Головна сторінка");
?>

<?php if(permission_check($_SESSION['permissions'], PERMISSION::administrator)): ?>
<div align="right" style="margin-bottom: 10px;">
	<a href="index.php?service=news.admin&create" class="btn btn-success btn-flat">Створити новину</a>
	<a href="index.php?service=news.admin" class="btn btn-primary btn-flat">Управління новинами</a>
</div>
<?php endif; ?>

<?php if ($_SPM_CONF["SECURITY"]["alpha_version_warning"]): ?>
<div class="callout callout-danger">
	<h4>УВАГА!</h4>
	<p>Встановлена версія системи SimplePM може містити в собі недоробки та помилки. Якщо ви знайшли помилку - будь ласка, зверніться до автора за email: admin@sirkadirov.com. Дякуємо!</p>
</div>
<?php endif; ?>


<?php if ($total_articles_number == 0 || $db_result->num_rows === 0): ?>
<div align="center">
	<h1>Упс!</h1>
	<p class="lead">Новин за вашим запитом не знайдено...</p>
</div>
<?php else: ?>
			
	<?php while ($article = $db_result->fetch_assoc()): ?>
		<div class="panel panel-primary" id="article-<?=$article['id']?>" style="margin-bottom: 10px; border-radius: 0;">
			<div class="panel-heading" style="border-radius: 0;">
				<h3 class="panel-title"><a href="#article-<?=$article['id']?>"><?=$article['title']?></a></h3>
			</div>
			<div class="panel-body" style="font-size: 12pt;">
				<?=htmlspecialchars_decode($article['content'])?>
			</div>
			<div class="panel-footer">
				<a href="index.php?service=user&id=<?=$article['authorId']?>">Профіль автора</a> / Дата публікації: <?=$article['date']?>
				
				<?php if (permission_check($_SESSION['permissions'], PERMISSION::administrator)): ?>
				&nbsp;/&nbsp;<a href='index.php?service=news.admin&edit=<?=$article["id"]?>'>Редагувати</a>
				<?php endif; ?>
			</div>
		</div>
	<?php endwhile; ?>
	
<?php endif; ?>

<?php include(_S_MOD_ . "pagination.php"); generatePagination($total_pages, $current_page, 4); ?>

<?php SPM_footer(); ?>