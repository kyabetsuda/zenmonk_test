<style>
	body{
		padding-top: 15vh;
	}
</style>
<?=$this->Form->create(null,['url'=>['controller'=>'users','action'=>'login']]) ?>
	<fieldset>
		<?=$this->Form->text("username") ?>
		<?=$this->Form->text("password") ?>
	</fieldset>
	<?=$this->Form->button("ログイン") ?>
<?=$this->Form->end() ?>
