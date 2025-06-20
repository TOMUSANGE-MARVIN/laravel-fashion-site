<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="{{ url('/') }}">
  <title>{{ __('install/common.install_wizard') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ image_origin(system_setting('favicon', 'images/favicon.png')) }}">
  <link rel="stylesheet" href="{{ asset('build/front/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('build/install/css/app.css') }}">
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @stack('header')
</head>

<body>
<header>
  <div class="container d-flex justify-content-between">
    <div class="logo"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></div>

    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false">
        {{ current_install_locale()['name'] }}
      </button>
      <ul class="dropdown-menu">
        @foreach(install_locales() as $item)
          <li><a class="dropdown-item"
                 href="{{ route('install.install.index', ['locale' => $item['code']]) }}">{{ $item['name'] }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
</header>
<div class="container">
  <div class="install-box">
    <ul class="progress-wrap">
      <li class="active">
        <div class="icon"><span>1</span></div>
        <div class="text">{{ __('install/common.license') }}</div>
      </li>
      <li>
        <div class="icon"><span>2</span></div>
        <div class="text">{{ __('install/common.environment') }}</div>
      </li>
      <li>
        <div class="icon"><span>3</span></div>
        <div class="text">{{ __('install/common.configuration') }}</div>
      </li>
      <li>
        <div class="icon"><span>4</span></div>
        <div class="text">{{ __('install/common.completed') }}</div>
      </li>
    </ul>
    <div class="install-wrap">
      <div class="install-1 install-item active">
        <div class="head-title">{{ __('install/common.open_source') }}</div>
        <div class="install-content" id="content">
          @if (view()->exists("install::license.{$locale}"))
            @include("install::license.{$locale}")
          @else
            @include("install::license.en")
          @endif
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="button" class="btn btn-primary btn-lg next-btn">{{ __('install/common.i_agree') }}</button>
        </div>
      </div>

      <div class="install-2 install-item d-none">

        <div class="head-title">
          <div class="row">
            <div class="col-6">{{ __('install/common.env_detection') }}</div>
            <div class="col-6">
              <div class="row">
                <div class="col-8 text-end"><span class="driver">{{ __('install/common.db_driver') }}:</span></div>
                <div class="col-4">
                  <select id="db-driver" class="form-select form-select-sm">
                    <option value="mysql" selected>MySQL</option>
                    <option value="sqlite">SQLite</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="install-content env-check">
          @include('install::installer._env_check')
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="button"
                  class="btn btn-outline-secondary prev-btn me-3">{{ __('install/common.previous_step') }}</button>
          <button type="button" disabled class="btn btn-primary next-btn">{{ __('install/common.next_step') }}</button>
        </div>
      </div>

      <div class="install-3 install-item d-none">
        <div class="head-title">{{ __('install/common.param_config') }}</div>
        <div class="install-content">
          <form class="needs-validation" novalidate>
            <input type="hidden" name="db_type" value="">
            <div class="bg-light py-2 mb-2 text-center fw-bold">{{ __('install/common.db_config') }}</div>
            <div class="row gx-2">
              <div class="col-6">
                <div class="mb-3">
                  <label for="type" class="form-label">{{ __('install/common.db_type') }}</label>
                  <select class="form-select sql-type" id="type" name="db_type" required>
                    <option value="sqlite">SQLite</option>
                    <option value="mysql">MySQL</option>
                  </select>
                  <div class="invalid-feedback">{{ __('install/common.select_db_type') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="host" class="form-label">{{ __('install/common.host_address') }}</label>
                  <input type="text" class="form-control" id="host" name="db_hostname" required
                         placeholder="{{ __('install/common.host') }}"
                         value="127.0.0.1">
                  <div class="invalid-feedback">{{ __('install/common.host') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="port" class="form-label">{{ __('install/common.port_number') }}</label>
                  <input type="text" class="form-control" id="port" name="db_port" required
                         placeholder="{{ __('install/common.port') }}"
                         value="3306">
                  <div class="invalid-feedback">{{ __('install/common.port') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="database" class="form-label">{{ __('install/common.db_name') }}</label>
                  <input type="text" class="form-control" id="database" name="db_name" required value="innoshop"
                         placeholder="{{ __('install/common.db_name') }}">
                  <div class="invalid-feedback">{{ __('install/common.db_name') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="database" class="form-label">{{ __('install/common.table_prefix') }}</label>
                  <input type="text" class="form-control" id="db_prefix" name="db_prefix" value="inno_" required
                         placeholder="{{ __('install/common.table_prefix') }}">
                  <div class="invalid-feedback">{{ __('install/common.table_prefix') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="username" class="form-label">{{ __('install/common.db_account') }}</label>
                  <input type="text" class="form-control" id="username" name="db_username" required
                         placeholder="{{ __('install/common.db_account') }}">
                  <div class="invalid-feedback">{{ __('install/common.db_account') }}</div>
                </div>
              </div>
              <div class="col-6 mysql-item">
                <div class="mb-3">
                  <label for="password" class="form-label">{{ __('install/common.db_password') }}</label>
                  <input type="password" class="form-control" id="password" name="db_password"
                         placeholder="{{ __('install/common.db_password') }}">
                  <div class="invalid-feedback">{{ __('install/common.db_password') }}</div>
                </div>
              </div>
            </div>

            <div class="admin-setting d-none">
              <div class="bg-light py-2 mb-2 text-center fw-bold">{{ __('install/common.admin_config') }}</div>
              <div class="row">
                <div class="col-6">
                  <div class="mb-3">
                    <label for="admin_email" class="form-label">{{ __('install/common.admin_account') }}</label>
                    <input type="text" class="form-control" id="admin_email" name="admin_email" required
                           placeholder="{{ __('install/common.admin_account') }}" value="admin@innoshop.com">
                    <div class="invalid-feedback">{{ __('install/common.admin_account') }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="admin_password" class="form-label">{{ __('install/common.admin_password') }}</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required
                           placeholder="{{ __('install/common.admin_password') }}">
                    <div class="invalid-feedback">{{ __('install/common.admin_password') }}</div>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="d-none">{{ __('install/common.next_step') }}</button>
          </form>
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="button"
                  class="btn btn-outline-secondary prev-btn me-3">{{ __('install/common.previous_step') }}</button>
          <button type="button" disabled class="btn btn-primary next-btn">{{ __('install/common.next_step') }}</button>
        </div>
      </div>

      <div class="install-4 install-item install-success d-none">
        <div class="head-title">{{ __('install/common.install_complete') }}</div>
        <div class="install-content">
          <div class="icon"><img src="{{ asset('images/icons/install-icon-4.svg') }}" class="img-fluid"></div>
          <div class="success-text">
            {{ __('install/common.congratulations') }}
          </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
          <a href="{{ url('/') }}" class="btn btn-primary me-3">{{ __('install/common.visit_frontend') }}</a>
          <a href="{{ url('/panel') }}" class="btn btn-primary">{{ __('install/common.visit_backend') }}</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Initialize the installer when document is ready
  $(document).ready(() => {
    Installer.init();
  });

  // Global variables
  const Installer = {
    // Initialize the installer
    init() {
      this.bindEvents();
    },

    // Bind all event listeners
    bindEvents() {
      // Database driver selection
      $('#db-driver').on('change', (e) => this.handleDriverChange(e));
      
      // Next step button
      $('.next-btn').on('click', (e) => this.handleNextStep(e));
      
      // Previous step button
      $('.prev-btn').on('click', (e) => this.handlePrevStep(e));
      
      // Database type selection
      $('.sql-type').on('change', (e) => this.handleDbTypeChange(e));
      
      // MySQL input fields
      $('.mysql-item input').on('input', (e) => this.handleMysqlInput(e));
      
      // Form enter key
      $('form').on('keypress', (e) => this.handleFormKeypress(e));
    },

    // Handle database driver change
    handleDriverChange(e) {
      const code = $(e.currentTarget).val();
      layer.load(2, {shade: [0.3, '#fff']});
      
      $.ajax({
        url: '{{ $driver_url }}',
        type: "POST",
        data: {db_code: code, locale: '{{current_install_locale()['code']}}'},
        success: (response) => {
          $('.env-check').html(response);
        },
        error: (xhr, status, error) => {
          layer.msg(error);
        },
        complete: () => {
          layer.closeAll('loading');
        }
      });
    },

    // Handle next step button click
    handleNextStep(e) {
      const current = $('.install-item').filter('.active');
      const next = current.next('.install-item');
      
      if (next.length === 0) return;

      if (next.hasClass('install-2')) {
        this.checkStatus();
      }

      if (next.hasClass('install-3')) {
        $('input[name="db_type"]').val($('#db-driver').val());
        $('.sql-type').val($('#db-driver').val()).prop('disabled', 'disabled').trigger('change');
      }

      if (current.hasClass('install-3')) {
        const form = current.find('form');
        form.removeClass('was-validated');
        
        if (form[0].checkValidity() === false) {
          form.addClass('was-validated');
          return;
        }

        const data = form.serialize();
        this.checkComplete(data, () => this.activeStep(current, next));
        return;
      }

      this.activeStep(current, next);
    },

    // Handle previous step button click
    handlePrevStep(e) {
      const current = $('.install-item').filter('.active');
      const prev = current.prev('.install-item');
      
      $('.next-btn').prop('disabled', false);
      if (prev.length === 0) return;

      this.activeStep(current, prev);
    },

    // Handle database type change
    handleDbTypeChange(e) {
      const type = $(e.currentTarget).val();
      const mysqlItems = $('.mysql-item');
      const adminSetting = $('.admin-setting');
      const nextBtn = $('.next-btn');

      if (type === 'sqlite') {
        mysqlItems.find('input').prop('required', false).prop('disabled', true);
        adminSetting.removeClass('d-none');
        nextBtn.prop('disabled', false);
        this.checkConnect();
      } else {
        mysqlItems.find('input').prop('required', true).prop('disabled', false);
        adminSetting.addClass('d-none');
        nextBtn.prop('disabled', true);
      }
    },

    // Handle MySQL input fields change
    handleMysqlInput(e) {
      let timer = null;
      const flag = $('.mysql-item input').toArray().every(input => {
        return $(input).val() !== '' || $(input).attr('id') === 'password';
      });

      if (flag) {
        clearTimeout(timer);
        timer = setTimeout(() => this.checkConnect(), 500);
      }
    },

    // Check database connection
    checkConnect() {
      $.ajax({
        url: '/install/connected',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          locale: '{{ current_install_locale()["code"] }}',
          db_type: $('select[name="db_type"]').val(),
          db_hostname: $('#host').val(),
          db_port: $('#port').val(),
          db_name: $('#database').val(),
          db_prefix: $('#db_prefix').val(),
          db_username: $('#username').val(),
          db_password: $('#password').val(),
        },
        success: (res) => {
          if (res.db_success) {
            $('.is-invalid').removeClass('is-invalid').next().text('');
            $('.admin-setting').removeClass('d-none');
            $('.next-btn').prop('disabled', false);
            
            setTimeout(() => {
              $('.install-3 .install-content').animate({
                scrollTop: $('.install-3 .install-content')[0].scrollHeight
              }, 400);
            }, 200);
          } else {
            for (const key in res) {
              $(`input[name="${key}"]`).addClass('is-invalid').next().text(res[key]);
            }
          }
        }
      });
    },

    // Check installation completion
    checkComplete(data, callback) {
      layer.load(2, {shade: [0.3, '#fff']});
      $('.is-invalid').removeClass('is-invalid').next('.invalid-feedback').text('');
      
      data += '&locale={{ current_install_locale()["code"] }}';
      
      $.ajax({
        url: '/install/complete',
        type: 'POST',
        data: data,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (res) => {
          layer.closeAll('loading');
          if (res.success) {
            callback(res);
          } else {
            if (res.errors) {
              Object.keys(res.errors).forEach(key => {
                $(`input[name="${key}"]`).addClass('is-invalid')
                  .next('.invalid-feedback').text(res.errors[key][0]);
              });
            }
            if (res.message) {
              layer.msg(res.message);
            }
          }
        },
        error: (xhr) => {
          layer.closeAll('loading');
          // Safe error handling
          if (xhr.responseJSON) {
            const response = xhr.responseJSON;
            if (response.errors) {
              Object.keys(response.errors).forEach(key => {
                $(`input[name="${key}"]`).addClass('is-invalid')
                  .next('.invalid-feedback').text(response.errors[key][0]);
              });
            }
            if (response.message) {
              layer.msg(response.message);
            }
          } else {
            // Handle empty response or network error
            layer.msg('Connection error. Please check your database configuration.');
          }
        }
      });
    },

    // Check system requirements status
    checkStatus() {
      const flag = $('.install-2 table .bi').toArray()
        .every(icon => !$(icon).hasClass('text-danger'));

      if (flag) {
        $('.install-2 .next-btn').prop('disabled', false);
      } else {
        layer.msg('{{ __('install/common.check_system') }}');
      }
    },

    // Activate installation step
    activeStep(current, next) {
      const index = next.index();

      $('.progress-wrap li').removeClass('complete active');
      $('.install-wrap .install-item').removeClass('active').addClass('d-none');

      $('.progress-wrap li').each(function(i) {
        if (i < index) {
          $(this).addClass('complete active');
        }
      });

      $('.progress-wrap li').eq(next.index()).addClass('active');
      $('.install-wrap .install-' + (index + 1)).removeClass('d-none').addClass('active');
    },

    // Handle form enter key press
    handleFormKeypress(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
      }
    }
  };
</script>
</body>
</html>
