<?php session_start(); ?>
<h2>Keranjang Belanja</h2>

<?php if (!empty($_SESSION['keranjang'])): ?>
  <table border="1">
    <tr>
      <th>Mobil</th>
      <th>Gambar</th>
      <th>Harga</th>
      <th>Qty</th>
      <th>Total</th>
    </tr>

    <?php
    $total_harga = 0;
    foreach ($_SESSION['keranjang'] as $item):
      $subtotal = $item['harga'] * $item['qty'];
      $total_harga += $subtotal;
    ?>
    <tr>
      <td><?= htmlspecialchars($item['mobil']) ?></td>
      <td><img src="<?= htmlspecialchars($item['gambar']) ?>" width="100"></td>
      <td>Rp <?= number_format($item['harga']) ?></td>
      <td><?= $item['qty'] ?></td>
      <td>Rp <?= number_format($subtotal) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="4"><strong>Total</strong></td>
      <td><strong>Rp <?= number_format($total_harga) ?></strong></td>
    </tr>
  </table>

  <!-- Tambahan metode pengiriman -->
  <form action="selesai.php" method="post" style="margin-top: 20px;">
    <p><strong>Pilih metode pengiriman:</strong></p>
    <label><input type="radio" name="pengiriman" value="Delivery" required> Delivery</label><br>
    <label><input type="radio" name="pengiriman" value="Jemput di Tempat" required> Jemput di Tempat</label><br><br>

    <button type="submit">Checkout Sekarang</button>
  </form>
<?php else: ?>
  <p>Keranjang kosong.</p>
<?php endif; ?>
