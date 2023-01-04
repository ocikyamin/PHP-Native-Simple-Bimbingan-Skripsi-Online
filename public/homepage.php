<!-- ======= Hero Section ======= -->
  <section id="hero" style="background-image: url('assets/img/hero.webp');background-size:cover;">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
          <div>
            <h1 class="text-white">Bimbingan <b style="color: yellow">Tugas Akhir</b>  Online</h1>
            <h2 class="text-white"><span style="border: 1px solid #fff;padding: 3px;border-top-right-radius: 20px;border-bottom-left-radius: 20px;background: black">SEKOLAH TINGGI TEKNIK MALANG</span></h2>
            <a href="#about" class="btn-get-started scrollto">Mulai Bimbingan</a>
          </div>
        </div>
             <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
          <!-- <img src="front/assets/img/hero-img.png" class="img-fluid" alt=""> -->
          <img src="logo.png" class="img-fluid">

        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-6" data-aos="zoom-in">
            <img src="assets/img/about.webp" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content pt-4 pt-lg-0">
              <h3>Visi & Misi STT Malang</h3>
              <p class="fst-italic">
                Menjadi salah satu Perguruan Tinggi yang terbaik di Indonesia yang berbasiskan Teknologi Informatika dan Komunikasi dengan berstandarkan kualitas International.
              </p>
              <ul>
                <li><i class="bi bi-check-circle"></i> Menyelenggarakan program pendidikan tinggi yang menunjang penerapan teknologi informasi dan komunikasi berstandar internasional.</li>
                
                <li><i class="bi bi-check-circle"></i> Melaksanakan penelitian demi pencapaian kreativitas dan inovasi.</li>
                
                <li><i class="bi bi-check-circle"></i> Melakukan pengabdian kepada Masyarakat dalam mendistribusikan ilmu pengetahuan.</li>
                
              </ul>
              <!--<p>-->
              <!--  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate tera noden carma palorp mades tera.-->
              <!--</p>-->
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Persyaratan Bimbingan</h2>
          <p>Pastikan anda telah memenuhi persyaratan berikut ini sebelum memutuskan untuk membuat akun baru.. </p>
        </div>

        <div class="row">
          <?php 
          foreach ($result as $d):?>
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
            <div class="icon-box icon-box-pink">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4 class="title"><a href=""><?= $d['judul'] ?></a></h4>
              <p class="description"><?= $d['isi'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>

        </div>

      </div>
    </section><!-- End Services Section -->

   

  </main><!-- End #main -->