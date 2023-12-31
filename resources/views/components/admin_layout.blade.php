<!DOCTYPE html>
<html lang="en">
  <x-head />
<body>
  @if(session('alert'))
    <div class="alert alert-{{ session('alert')['type'] }} text-center">
      {{ session('alert')['message'] }}
    </div>
  @endif
  <x-admin_header />
  <div class="container-fluid sb2">
        <div class="row">
          <x-admin_sidebar />
          <div class="sb2-2">
            {{ $slot }}
          </div>
        </div>
  </div>
  <x-scriptLinks />
</body>
</html>
