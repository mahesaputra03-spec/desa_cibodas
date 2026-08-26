<?php
require_once 'config.php';
require_login();
$pdo = db();

if (isset($_GET['pdf'])) {
    $rows = $pdo->query("SELECT * FROM penduduk ORDER BY nama_lengkap ASC")->fetchAll();
    ?>
    <!doctype html><html lang="id"><head><meta charset="utf-8"><title>Data Penduduk - Desa Cibodas</title>
    <style>body{font-family:Arial,sans-serif;margin:20px}h2{text-align:center}table{width:100%;border-collapse:collapse;font-size:9px}th,td{border:1px solid #999;padding:4px}th{background:#eee}@media print{.no-print{display:none}}</style>
    </head><body><button class="no-print" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    <h2>DATA PENDUDUK DESA CIBODAS</h2><p>Total: <?=count($rows)?> penduduk</p>
    <table><thead><tr><th>No</th><th>No. KK</th><th>NIK</th><th>Nama</th><th>Agama</th><th>JK</th><th>Tempat/Tgl Lahir</th><th>RT/RW</th><th>Pekerjaan</th><th>Pendidikan</th><th>Status</th><th>Gol. Darah</th></tr></thead><tbody>
    <?php foreach($rows as $i=>$r): ?><tr><td><?=$i+1?></td><td><?=e($r['no_kk'])?></td><td><?=e($r['nik'])?></td><td><?=e($r['nama_lengkap'])?></td><td><?=e($r['agama'])?></td><td><?=e($r['jenis_kelamin'])?></td><td><?=e($r['tempat_lahir'])?> / <?=e($r['tanggal_lahir'])?></td><td><?=e($r['rt'])?>/<?=e($r['rw'])?></td><td><?=e($r['pekerjaan'])?></td><td><?=e($r['pendidikan'])?></td><td><?=e($r['status_perkawinan'])?></td><td><?=e($r['golongan_darah'])?></td></tr><?php endforeach; ?>
    </tbody></table></body></html><?php exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM penduduk WHERE id=?"); $stmt->execute([(int)$_POST['id']]);
    } else {
        $data = [
          trim($_POST['no_kk']??''), trim($_POST['nik']??''), trim($_POST['nama_lengkap']??''), trim($_POST['agama']??''),
          trim($_POST['jenis_kelamin']??''), trim($_POST['tempat_lahir']??''), $_POST['tanggal_lahir']??'', trim($_POST['rt']??''),
          trim($_POST['rw']??''), trim($_POST['pekerjaan']??''), trim($_POST['pendidikan']??''), trim($_POST['status_perkawinan']??''),
          trim($_POST['golongan_darah']??'')
        ];
        if ($action === 'add') {
            $pdo->prepare("INSERT INTO penduduk(no_kk,nik,nama_lengkap,agama,jenis_kelamin,tempat_lahir,tanggal_lahir,rt,rw,pekerjaan,pendidikan,status_perkawinan,golongan_darah) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute($data);
        } elseif ($action === 'edit') {
            $data[] = (int)$_POST['id'];
            $pdo->prepare("UPDATE penduduk SET no_kk=?,nik=?,nama_lengkap=?,agama=?,jenis_kelamin=?,tempat_lahir=?,tanggal_lahir=?,rt=?,rw=?,pekerjaan=?,pendidikan=?,status_perkawinan=?,golongan_darah=? WHERE id=?")->execute($data);
        }
    }
    header('Location: penduduk.php'); exit;
}
$q = trim($_GET['q'] ?? '');
if ($q) {
    $like = "%$q%"; $stmt=$pdo->prepare("SELECT * FROM penduduk WHERE no_kk LIKE ? OR nik LIKE ? OR nama_lengkap LIKE ? ORDER BY nama_lengkap"); $stmt->execute([$like,$like,$like]); $rows=$stmt->fetchAll();
} else $rows=$pdo->query("SELECT * FROM penduduk ORDER BY nama_lengkap")->fetchAll();
$edit = null;
if (isset($_GET['edit'])) { $s=$pdo->prepare("SELECT * FROM penduduk WHERE id=?"); $s->execute([(int)$_GET['edit']]); $edit=$s->fetch(); }
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Data Penduduk</title><link rel="stylesheet" href="assets/style.css"></head><body><div class="app"><aside class="sidebar"><div class="brand"><div class="logo">DC</div><div><b>Desa Cibodas</b><small>Sistem Kependudukan</small></div></div><nav><a href="index.php">Dashboard</a><a class="active" href="penduduk.php">Data Penduduk</a><a href="mutasi.php?jenis=datang">Penduduk Datang</a><a href="mutasi.php?jenis=pindah">Penduduk Pindah</a><a href="mutasi.php?jenis=meninggal">Penduduk Meninggal</a><a href="mutasi.php?jenis=lahir">Penduduk Baru Lahir</a></nav><a class="logout" href="logout.php">Keluar</a></aside>
<main class="main"><header class="topbar"><div><h1>Data Penduduk</h1><p><?=count($rows)?> data ditemukan.</p></div></header>
<?php if(isset($_GET['action']) || $edit): $r=$edit ?: array_fill_keys(['no_kk','nik','nama_lengkap','agama','jenis_kelamin','tempat_lahir','tanggal_lahir','rt','rw','pekerjaan','pendidikan','status_perkawinan','golongan_darah'],''); ?>
<section class="panel"><h2><?=$edit?'Edit':'Tambah'?> Penduduk</h2><form class="grid-form" method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="<?=$edit?'edit':'add'?>"><?php if($edit): ?><input type="hidden" name="id" value="<?=$edit['id']?>"><?php endif; ?>
<?php $fields=[['no_kk','Nomor Kartu Keluarga'],['nik','NIK'],['nama_lengkap','Nama Lengkap'],['agama','Agama'],['jenis_kelamin','Jenis Kelamin'],['tempat_lahir','Tempat Kelahiran'],['tanggal_lahir','Tanggal Lahir'],['rt','RT'],['rw','RW'],['pekerjaan','Pekerjaan'],['pendidikan','Pendidikan Terakhir'],['status_perkawinan','Status Perkawinan'],['golongan_darah','Golongan Darah']]; foreach($fields as [$name,$label]): ?><label><?=$label?><input name="<?=$name?>" value="<?=e((string)$r[$name])?>" <?=$name==='tanggal_lahir'?'type="date"':''?> required></label><?php endforeach; ?>
<div class="form-actions"><button type="submit">Simpan</button><a class="button secondary" href="penduduk.php">Batal</a></div></form></section>
<?php endif; ?>
<section class="panel"><div class="toolbar"><form><input name="q" value="<?=e($q)?>" placeholder="Cari NIK, KK, atau nama..."><button>Cari</button></form><div><a class="button" href="penduduk.php?action=add">+ Tambah</a> <a class="button secondary" href="penduduk.php?pdf=1" target="_blank">PDF</a></div></div>
<div class="table-wrap"><table><thead><tr><th>No</th><th>KK</th><th>NIK</th><th>Nama</th><th>JK</th><th>TTL</th><th>RT/RW</th><th>Pekerjaan</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $i=>$r): ?><tr><td><?=$i+1?></td><td><?=e($r['no_kk'])?></td><td><?=e($r['nik'])?></td><td><b><?=e($r['nama_lengkap'])?></b><br><small><?=e($r['agama'])?></small></td><td><?=e($r['jenis_kelamin'])?></td><td><?=e($r['tempat_lahir'])?><br><?=e($r['tanggal_lahir'])?></td><td><?=e($r['rt'])?>/<?=e($r['rw'])?></td><td><?=e($r['pekerjaan'])?></td><td class="actions"><a href="?edit=<?=$r['id']?>">Edit</a><form method="post" onsubmit="return confirm('Hapus data ini?')"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="link-danger">Hapus</button></form></td></tr><?php endforeach; ?></tbody></table></div></section></main></div></body></html>
