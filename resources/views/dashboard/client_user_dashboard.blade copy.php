<!DOCTYPE html>
<html lang="en" data-footer="true">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Acorn Admin Template | Medical Assistant</title>
    <meta name="description" content="Medical Assistant" />
    <!-- Favicon Tags Start -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="img/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="img/favicon/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="img/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="img/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="img/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="img/favicon/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="img/favicon/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="img/favicon/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="img/favicon/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="img/favicon/mstile-310x310.png" />
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('acron/style.css')}}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{ asset('acron/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('acron/OverlayScrollbars.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('acron/glide.core.min.css')}}" />

    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="{{ asset('acron/styles.css')}}" />
    <!-- Template Base Styles End -->

    <link rel="stylesheet" href="{{ asset('acron/main.css')}}" />
    <script src="{{ asset('acron/loader.js')}}"></script>
  </head>

  <body class="rtl">
    <div id="root">
      <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex">
          <!-- Logo Start -->
          <div class="logo position-relative">
            <a href="Dashboards.Patient.html">
              <!-- Logo can be added directly -->
              <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

              <!-- Or added via css to provide different ones for different color themes -->
              <div class="img"></div>
            </a>
          </div>
          <!-- Logo End -->

          <!-- User Menu Start -->
          <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="profile" alt="profile" src="img/profile/profile-1.webp" />
              <div class="name">Alicia Owens</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end user-menu wide">
              <div class="row mb-3 ms-0 me-0">
                <div class="col-12 ps-1 mb-2">
                  <div class="text-extra-small text-primary">ACCOUNT</div>
                </div>
                <div class="col-6 ps-1 pe-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">User Info</a>
                    </li>
                    <li>
                      <a href="#">Preferences</a>
                    </li>
                    <li>
                      <a href="#">Calendar</a>
                    </li>
                  </ul>
                </div>
                <div class="col-6 pe-1 ps-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">Security</a>
                    </li>
                    <li>
                      <a href="#">Billing</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row mb-1 ms-0 me-0">
                <div class="col-12 p-1 mb-2 pt-2">
                  <div class="text-extra-small text-primary">APPLICATION</div>
                </div>
                <div class="col-6 ps-1 pe-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">Themes</a>
                    </li>
                    <li>
                      <a href="#">Language</a>
                    </li>
                  </ul>
                </div>
                <div class="col-6 pe-1 ps-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">Devices</a>
                    </li>
                    <li>
                      <a href="#">Storage</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row mb-1 ms-0 me-0">
                <div class="col-12 p-1 mb-3 pt-3">
                  <div class="separator-light"></div>
                </div>
                <div class="col-6 ps-1 pe-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">
                        <i data-acorn-icon="help" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">Help</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i data-acorn-icon="file-text" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">Docs</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-6 pe-1 ps-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="#">
                        <i data-acorn-icon="gear" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">Logout</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- User Menu End -->

          <!-- Icons Menu Start -->
          <ul class="list-unstyled list-inline text-center menu-icons">
            <li class="list-inline-item">
              <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
                <i data-acorn-icon="search" data-acorn-size="18"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#" id="pinButton" class="pin-button">
                <i data-acorn-icon="lock-on" class="unpin" data-acorn-size="18"></i>
                <i data-acorn-icon="lock-off" class="pin" data-acorn-size="18"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#" id="colorButton">
                <i data-acorn-icon="light-on" class="light" data-acorn-size="18"></i>
                <i data-acorn-icon="light-off" class="dark" data-acorn-size="18"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#" data-bs-toggle="dropdown" data-bs-target="#notifications" aria-haspopup="true" aria-expanded="false" class="notification-button">
                <div class="position-relative d-inline-flex">
                  <i data-acorn-icon="bell" data-acorn-size="18"></i>
                  <span class="position-absolute notification-dot rounded-xl"></span>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out" id="notifications">
                <div class="scroll">
                  <ul class="list-unstyled border-last-none">
                    <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                      <img src="img/profile/profile-1.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                      <div class="align-self-center">
                        <a href="#">Joisse Kaycee just sent a new comment!</a>
                      </div>
                    </li>
                    <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                      <img src="img/profile/profile-2.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                      <div class="align-self-center">
                        <a href="#">New order received! It is total $147,20.</a>
                      </div>
                    </li>
                    <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                      <img src="img/profile/profile-3.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                      <div class="align-self-center">
                        <a href="#">3 items just added to wish list by a user!</a>
                      </div>
                    </li>
                    <li class="pb-3 pb-3 border-bottom border-separator-light d-flex">
                      <img src="img/profile/profile-6.webp" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                      <div class="align-self-center">
                        <a href="#">Kirby Peters just sent a new message!</a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
          <!-- Icons Menu End -->

          <!-- Menu Start -->
          <div class="menu-container flex-grow-1">
            <ul id="menu" class="menu">
              <li>
                <a href="#dashboards" data-href="Dashboards.Patient.html">
                  <i data-acorn-icon="home-garage" class="icon" data-acorn-size="18"></i>
                  <span class="label">Dashboards</span>
                </a>
                <ul id="dashboards">
                  <li>
                    <a href="Dashboards.Patient.html">
                      <span class="label">Patient</span>
                    </a>
                  </li>
                  <li>
                    <a href="Dashboards.Doctor.html">
                      <span class="label">Doctor</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="Appointments.html">
                  <i data-acorn-icon="calendar" class="icon" data-acorn-size="18"></i>
                  <span class="label">Appointments</span>
                </a>
              </li>
              <li>
                <a href="Results.html">
                  <i data-acorn-icon="form-check" class="icon" data-acorn-size="18"></i>
                  <span class="label">Results</span>
                </a>
              </li>
              <li>
                <a href="Prescriptions.html">
                  <i data-acorn-icon="inbox" class="icon" data-acorn-size="18"></i>
                  <span class="label">Prescriptions</span>
                </a>
              </li>
              <li>
                <a href="Doctors.html">
                  <i data-acorn-icon="health" class="icon" data-acorn-size="18"></i>
                  <span class="label">Doctors</span>
                </a>
              </li>
              <li>
                <a href="Consult.html">
                  <i data-acorn-icon="messages" class="icon" data-acorn-size="18"></i>
                  <span class="label">Consult</span>
                </a>
              </li>
              <li>
                <a href="Guidebook.html">
                  <i data-acorn-icon="book-open" class="icon" data-acorn-size="18"></i>
                  <span class="label">Guidebook</span>
                </a>
              </li>
              <li>
                <a href="Articles.html">
                  <i data-acorn-icon="book" class="icon" data-acorn-size="18"></i>
                  <span class="label">Articles</span>
                </a>
              </li>
              <li>
                <a href="Settings.html">
                  <i data-acorn-icon="gear" class="icon" data-acorn-size="18"></i>
                  <span class="label">Settings</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- Menu End -->

          <!-- Mobile Buttons Start -->
          <div class="mobile-buttons-container">
            <!-- Menu Button Start -->
            <a href="#" id="mobileMenuButton" class="menu-button">
              <i data-acorn-icon="menu"></i>
            </a>
            <!-- Menu Button End -->
          </div>
          <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
      </div>

      <main>
        <div class="container">
          <!-- Title and Top Buttons Start -->
          <div class="page-title-container">
            <div class="row">
              <!-- Title Start -->
              <div class="col-12 col-md-7">
                <span class="align-middle text-muted d-inline-block lh-1 pb-2 pt-2 text-small">Home</span>
                <h1 class="mb-0 pb-0 display-4" id="title">Good morning, Alicia!</h1>
              </div>
              <!-- Title End -->
            </div>
          </div>
          <!-- Title and Top Buttons End -->

          <div class="row">
            <div class="col-xl-4 mb-5">
              <!-- About Start -->
              <h2 class="small-title">About</h2>
              <div class="card h-100-card">
                <div class="card-body">
                  <div class="d-flex align-items-center flex-column mb-4">
                    <div class="d-flex align-items-center flex-column">
                      <div class="sw-13 position-relative mb-3">
                        <img src="img/profile/profile-1.webp" class="img-fluid rounded-xl" alt="thumb" />
                      </div>
                      <div class="h5 mb-0">Alicia Owens</div>
                      <div class="text-muted">Highschool Teacher</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">BLOOD</p>
                      <p>A+</p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">AGE</p>
                      <p>27</p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">WEIGHT</p>
                      <p>64</p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">HEIGHT</p>
                      <p>1.68</p>
                    </div>
                  </div>
                  <div class="mb-5">
                    <p class="text-small text-muted mb-2">DIOGNOSTICS</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="lungs" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">Allergic Rhinitis</div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="brain" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">Diabetic Ketoacidosis</div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="stomach" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">Cervical Spondylosis</div>
                    </div>
                  </div>

                  <div class="mb-5">
                    <p class="text-small text-muted mb-2">CONTACT</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="phone" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">+6443884455</div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="email" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">aliciaowens@gmail.com</div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="pin" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">Wellington New Zealand</div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <p class="text-small text-muted mb-2">DOCTOR</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="health" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate align-middle">Antoine Spears</div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="building" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">The Royal Melbourne Hospital City</div>
                    </div>
                  </div>

                  <div>
                    <p class="text-small text-muted mb-2">NOTES</p>
                    <div class="row g-0">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="warning-hexagon" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate align-middle">Penicillin Allergy</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- About End -->
            </div>
            <div class="col-xl-8">
              <!-- Stats Start -->
              <h2 class="small-title">Stats</h2>
              <div class="row gx-2">
                <div class="col-12 p-0">
                  <div class="glide glide-small" id="statsCarousel">
                    <div class="glide__track" data-glide-el="track">
                      <div class="glide__slides">
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="blood" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Blood
                                <br />
                                Pressure
                              </div>
                              <div class="display-6 text-primary">115/74</div>
                            </div>
                          </div>
                        </div>
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="heart" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Heart
                                <br />
                                Rate
                              </div>
                              <div class="display-6 text-primary">93</div>
                            </div>
                          </div>
                        </div>
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="chevron-bottom" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="laboratory" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Glucose
                                <br />
                                Level
                              </div>
                              <div class="display-6 text-primary">82</div>
                            </div>
                          </div>
                        </div>
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="chevron-top" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="weight" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Body Mass
                                <br />
                                Index
                              </div>
                              <div class="display-6 text-primary">19.4</div>
                            </div>
                          </div>
                        </div>
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="thermometer" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Body
                                <br />
                                Temperature
                              </div>
                              <div class="display-6 text-primary">37.2</div>
                            </div>
                          </div>
                        </div>
                        <div class="glide__slide">
                          <div class="card mb-5 hover-border-primary">
                            <span class="position-absolute e-3 t-4 z-index-1">
                              <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                            </span>
                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                              <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                <i data-acorn-icon="blood-bag" class="text-primary"></i>
                              </div>
                              <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                Blood
                                <br />
                                Count
                              </div>
                              <div class="display-6 text-primary">4.2</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Stats End -->

              <div class="row">
                <!-- Appointments Start -->
                <div class="col-xl-6 mb-5">
                  <div class="d-flex justify-content-between">
                    <h2 class="small-title">Appointments</h2>
                    <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small" type="button">
                      <span class="align-bottom">Add New</span>
                      <i data-acorn-icon="chevron-right" class="align-middle" data-acorn-size="12"></i>
                    </button>
                  </div>
                  <div class="card h-xl-100-card">
                    <div class="card-header border-0 pb-0 d-flex justify-content-center">
                      <div class="glide-tab-container">
                        <div class="glide glide-tab" id="appointmentsCarousel">
                          <div class="glide__track" data-glide-el="track">
                            <div class="glide__slides nav nav-pills" role="tablist">
                              <div class="glide__slide active" data-bs-toggle="tab" data-bs-target="#dayOne" role="tab" aria-selected="true">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-alternate mb-2">Mo</div>
                                  <div class="text-primary">18</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Tu</div>
                                  <div class="text-separator">19</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayTwo" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-alternate mb-2">We</div>
                                  <div class="text-primary">20</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayThree" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-alternate mb-2">Th</div>
                                  <div class="text-primary">21</div>
                                </button>
                              </div>

                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Fr</div>
                                  <div class="text-separator">22</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">St</div>
                                  <div class="text-separator">23</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Su</div>
                                  <div class="text-separator">24</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Mo</div>
                                  <div class="text-separator">25</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Tu</div>
                                  <div class="text-separator">26</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">We</div>
                                  <div class="text-separator">27</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Th</div>
                                  <div class="text-separator">28</div>
                                </button>
                              </div>
                              <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                                <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                                  <div class="text-separator mb-2">Fr</div>
                                  <div class="text-separator">29</div>
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="glide__arrows" data-glide-el="controls">
                            <button class="btn btn-icon btn-icon-only btn-link left-arrow btn-sm mt-3" data-glide-dir="<">
                              <i data-acorn-icon="chevron-left"></i>
                            </button>
                            <button class="btn btn-icon btn-icon-only btn-link right-arrow btn-sm mt-3" data-glide-dir=">">
                              <i data-acorn-icon="chevron-right"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pt-3">
                      <div class="tab-content">
                        <div class="tab-pane fade active show mb-n3" id="dayOne" role="tabpanel">
                          <div class="mb-4 text-primary text-center">18 December 2021, Monday</div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="lungs" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Rheumatologist</div>
                                  <div class="text-muted">12:00</div>
                                  <div class="text-muted">Zayn Hartley, M.D.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="surgery" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Surgeon</div>
                                  <div class="text-muted">14:00</div>
                                  <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="stomach" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Endocrinologist</div>
                                  <div class="text-muted">14:30</div>
                                  <div class="text-muted">Wiebe Rodolfo, M.D.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade mb-n3" id="dayTwo" role="tabpanel">
                          <div class="mb-4 text-primary text-center">20 December 2021, Wednesday</div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="xray" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Ophthalmologist</div>
                                  <div class="text-muted">10:00</div>
                                  <div class="text-muted">Zayn Hartley, M.D.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="gynecology" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Surgeon</div>
                                  <div class="text-muted">11:30</div>
                                  <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="dna" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Otolaryngologist</div>
                                  <div class="text-muted">11:45</div>
                                  <div class="text-muted">Kathryn Mengel, M.D.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade mb-n3" id="dayThree" role="tabpanel">
                          <div class="mb-4 text-primary text-center">21 December 2021, Thursday</div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="dermatology" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Dermatologist</div>
                                  <div class="text-muted">12:00</div>
                                  <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="gynecology" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Surgeon</div>
                                  <div class="text-muted">14:00</div>
                                  <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row g-0 mb-3">
                            <div class="col-auto">
                              <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                                <i data-acorn-icon="stomach" class="text-primary"></i>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                  <div class="text-body">Neurologist</div>
                                  <div class="text-muted">18:30</div>
                                  <div class="text-muted">Wiebe Rodolfo, M.D.</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="dayNone" role="tabpanel">
                          <div class="mb-4 text-primary text-center">19 December 2021, Tuesday</div>
                          <div class="text-center">
                            <img src="img/illustration/icon-appointment.webp" class="theme-filter" alt="launch" />
                            <p>No appointments for the day!</p>
                            <button class="btn btn-icon btn-icon-start btn-primary" type="button">
                              <i data-acorn-icon="calendar"></i>
                              <span>New Appointment</span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Appointments End -->

                <!-- Your Doctors Start -->
                <div class="col-xl-6 mb-5">
                  <h2 class="small-title">Your Doctors</h2>
                  <div class="card">
                    <div class="card-body mb-n3 border-last-none">
                      <div class="mb-3 pb-3 border-bottom border-separator-light">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <a href="Doctors.Detail.html">
                              <img src="img/profile/profile-14.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                            </a>
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <a href="Doctors.Detail.html" class="body-link">Karter Kidd, M.D.</a>
                                <div class="text-small text-muted">Neurologist</div>
                              </div>
                              <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                                <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                                  <i data-acorn-icon="more-vertical"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3 pb-3 border-bottom border-separator-light">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <a href="Doctors.Detail.html">
                              <img src="img/profile/profile-12.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                            </a>
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <a href="Doctors.Detail.html" class="body-link">Carmelo Avril, M.B.B.S.</a>
                                <div class="text-small text-muted">Rheumatologist</div>
                              </div>
                              <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                                <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                                  <i data-acorn-icon="more-vertical"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3 pb-3 border-bottom border-separator-light">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <a href="Doctors.Detail.html">
                              <img src="img/profile/profile-13.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                            </a>
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <a href="Doctors.Detail.html" class="body-link">Wiebe Rodolfo, M.D.</a>
                                <div class="text-small text-muted">Psychiatrist</div>
                              </div>
                              <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                                <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                                  <i data-acorn-icon="more-vertical"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3 pb-3 border-bottom border-separator-light">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <a href="Doctors.Detail.html">
                              <img src="img/profile/profile-15.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                            </a>
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <a href="Doctors.Detail.html" class="body-link">Alma Holder, D.M.S.</a>
                                <div class="text-small text-muted">Ophthalmologist</div>
                              </div>
                              <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                                <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                                  <i data-acorn-icon="more-vertical"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3 border-bottom border-separator-light">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <a href="Doctors.Detail.html">
                              <img src="img/profile/profile-16.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                            </a>
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <a href="Doctors.Detail.html" class="body-link">Isaac Mckee, D.O.</a>
                                <div class="text-small text-muted">Neurologist</div>
                              </div>
                              <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                                <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                                  <i data-acorn-icon="more-vertical"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Your Doctors End -->
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Results Start -->
            <div class="col-xl-6 mb-5">
              <h2 class="small-title">Results</h2>
              <div class="card mb-2 sh-11 sh-md-8">
                <div class="card-body pt-0 pb-0 h-100">
                  <div class="row g-0 h-100 align-content-center">
                    <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                      <a href="Results.Detail.html" class="body-link text-truncate">
                        <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                        <span class="align-middle">blood-analysis.pdf</span>
                      </a>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">12.11.2021</div>
                    <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                      <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                        <i data-acorn-icon="arrow-bottom"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-2 sh-11 sh-md-8">
                <div class="card-body pt-0 pb-0 h-100">
                  <div class="row g-0 h-100 align-content-center">
                    <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                      <a href="Results.Detail.html" class="body-link text-truncate">
                        <i data-acorn-icon="image" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                        <span class="align-middle">hearth-imaging.pdf</span>
                      </a>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">05.11.2021</div>
                    <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                      <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                        <i data-acorn-icon="arrow-bottom"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-2 sh-11 sh-md-8">
                <div class="card-body pt-0 pb-0 h-100">
                  <div class="row g-0 h-100 align-content-center">
                    <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                      <a href="Results.Detail.html" class="body-link text-truncate">
                        <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                        <span class="align-middle">blood-analysis.pdf</span>
                      </a>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">02.11.2021</div>
                    <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                      <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                        <i data-acorn-icon="arrow-bottom"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card sh-11 sh-md-8">
                <div class="card-body pt-0 pb-0 h-100">
                  <div class="row g-0 h-100 align-content-center">
                    <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                      <a href="Results.Detail.html" class="body-link text-truncate">
                        <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                        <span class="align-middle">allergy-test.pdf</span>
                      </a>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">02.11.2021</div>
                    <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                      <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                        <i data-acorn-icon="arrow-bottom"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Results End -->

            <!-- Check Up Start -->
            <div class="col-xl-6 mb-5">
              <h2 class="small-title">Check Up</h2>
              <div class="card w-100 sh-100 h-xl-100-card hover-img-scale-up position-relative">
                <img src="img/banner/cta-doctor.webp" class="card-img h-100 scale position-absolute" alt="card image" />
                <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                  <div>
                    <div class="cta-2 mb-0 text-black w-75 w-sm-50">Check Yourself Up</div>
                    <div class="cta-2 mb-3 text-black w-75 w-sm-50">30% Off</div>
                    <div class="w-50 text-black mb-3">
                      Liquorice caramels chupa chups bonbon. Jelly-o candy sugar chocolate cake caramels apple pie lollipop jujubes.
                    </div>
                  </div>
                  <div>
                    <a href="Appointments.New.html" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                      <i data-acorn-icon="chevron-right"></i>
                      <span>View</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- Check Up End -->
          </div>
        </div>
      </main>
  
    </div>



    <!-- Vendor Scripts Start -->
    <script src="{{ asset('acron/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('acron/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('acron/OverlayScrollbars.min.js')}}"></script>
    <script src="{{ asset('acron/autoComplete.min.js')}}"></script>
    <script src="{{ asset('acron/clamp.min.js')}}"></script>
    <script src="{{ asset('acron/acorn-icons.js')}}"></script>
    <script src="{{ asset('acron/acorn-icons-interface.js')}}"></script>
    <script src="{{ asset('acron/acorn-icons-medical.js')}}"></script>

    <script src="{{ asset('acron/glide.min.js')}}"></script>

    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="{{ asset('acron/helpers.js')}}"></script>
    <script src="{{ asset('acron/globals.js')}}"></script>
    <script src="{{ asset('acron/nav.js')}}"></script>
    <script src="{{ asset('acron/search.js')}}"></script>
    <script src="{{ asset('acron/settings.js')}}"></script>
    <!-- Template Base Scripts End -->
    <!-- Page Specific Scripts Start -->

    <script src="{{ asset('acron/glide.custom.js')}}"></script>

    <script src="{{ asset('acron/dashboards.patient.js')}}"></script>

    <script src="{{ asset('acron/common.js')}}"></script>
    <script src="{{ asset('acron/scripts.js')}}"></script>
    <!-- Page Specific Scripts End -->
  </body>
</html>
