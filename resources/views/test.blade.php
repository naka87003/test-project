<x-guest-layout>
  <x-primary-button>
    こんにちは
  </x-primary-button>
  @foreach($users as $user)
  <p>{{$user->name}}</p>
  @endforeach
</x-guest-layout>