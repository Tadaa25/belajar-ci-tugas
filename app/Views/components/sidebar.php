<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li><!-- End Keranjang Nav -->
        <?php
        if (session()->get('role') == 'admin') {
        ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (uri_string() == 'paket') ? "" : "collapsed" ?>" href="paket">
                    <i class="bi bi-receipt"></i>
                    <span>Produk</span>
                </a>
            </li><!-- End Produk Nav -->
            <li class="nav-item">
                 <a class="nav-link <?php echo (uri_string() == 'riwayat') ? '' : 'collapsed' ?>" href="<?= base_url('riwayat') ?>">
                <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
             </a>
                </li>
        <?php
        }
        ?>\
    </ul>

</aside><!-- End Sidebar-->