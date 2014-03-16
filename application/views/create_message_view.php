<form action="<?=site_url('messages/create_message')?>">
	<input type="hidden" name="sender" value="<?=$this->session->userdata('family_name')?>"></input>
	<input type="text" name="subject"></input>
	<input type="text" name="message"></input>
</form>