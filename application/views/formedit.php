<?php
	defined('BASEPATH') OR exit('Akses langsung tidak diperbolehkan');
	//echo validation_errors();
?>

<section class="container-fluid">
	<div class="row">
		<div class="form-input clearfix">
			<div class="col-md-12">

				<div class="panel panel-primary">
					<div class="panel-heading">Edit Data Transaksi</div>
					<div class="panel-body">
						<!-- <form action="<?php //echo base_url('home/tambahmobil'); ?>" method="post" class="form-horizontal"> -->
						
						<?php echo form_open('admin/home/updatetransaksi/'.$db->id, ['class' => 'form-horizontal', 'method' => 'post']); ?>
							<div class="form-group <?php echo (form_error('id') != '') ? 'has-error has-feedback' : '' ?>">
								<label for="id" class="control-label col-sm-2">Kode Mobil </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="id" value="<?php echo set_value('id', $db->id); ?>" readonly>
									<?php echo (form_error('id') != '') ? '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' : '' ?>
									<?php echo form_error('id'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="kode" class="control-label col-sm-2">Kode </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="kode" value="<?php echo set_value('kode', $db->kode); ?>">
									<?php echo form_error('kode'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="nama" class="control-label col-sm-2">Nama </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nama" value="<?php echo set_value('nama', $db->nama); ?>">
									<?php echo form_error('nama'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="tanggal" class="control-label col-sm-2">Tanggal </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="tanggal" value="<?php echo set_value('tanggal', $db->tanggal); ?>">
									<?php echo form_error('tanggal'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="keterangan" class="control-label col-sm-2">Keterangan </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="keterangan" value="<?php echo set_value('keterangan', $db->keterangan); ?>">
									<?php echo form_error('keterangan'); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="btn-form col-sm-12">
									<a href="<?php echo base_url('home/lihatdata'); ?>"><button type="button" class='btn btn-default'>Batal</button></a>
									<button type="submit" class='btn btn-primary'>Simpan</button>
								</div>
							</div>
						<?php echo form_close(); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>