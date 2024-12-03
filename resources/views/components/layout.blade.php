<!DOCTYPE html>
<html lang="en">
<x-head />
<body>
  @if(Session::get('success',false))
  <?php $data = Session::get('success'); ?>
    @if (is_array($data))
            @foreach ($data as $msg)
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check"></i>
                    {{ $msg }}
                </div>
            @endforeach
        @else
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $data }}
            </div>
    @endif
  @endif
  <x-header />
  {{-- <x-search_box /> --}}
  {{-- <x-mobileMenu /> --}}
  {{ $slot }}
  {{-- <x-socialShare /> --}}
  {{-- <x-userLoginRegister /> --}}
  <x-footer />
  <x-scriptLinks />
</body>