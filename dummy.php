<!-- Navigasi -->
<div class="pagination">
            <?php if($halamanAktif > 1): ?>
                <a href="?page=<?= $halamanAktif-1 ?><?= $keyword ? '&keyword='.urlencode($keyword) : '' ?>">&laquo;</a>
            <?php endif; ?>
                
            <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <?php if($i == $halamanAktif): ?>
                    <a href="?page=<?= $i ?><?= $keyword ? '&keyword='.urlencode($keyword) : '' ?>" style="font-weight: bold; color: red"><?= $i ?></a>
                <?php else: ?>
                    <a href="?page=<?= $i ?><?= $keyword ? '&keyword='.urlencode($keyword) : '' ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($halamanAktif < $jumlahHalaman): ?>
                <a href="?page=<?= $halamanAktif+1 ?><?= $keyword ? '&keyword='.urlencode($keyword) : '' ?>">&raquo;</a>
            <?php endif; ?>
        </div>