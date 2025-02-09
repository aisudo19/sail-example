<x-app-layout>
  <x-slot name="script">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="/js/recipe/create.js"></script>
  </x-slot>
  <form action="{{ route('recipe.store')}}" method="POST" class="w-10/12 p-4 mx-auto bg-white rounded"
    enctype="multipart/form-data">
    @csrf
    {{ Breadcrumbs::render('create') }}
    <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
      <div class="col-span-1">
        <img class="object-cover w-full aspect-video" src="/images/recipe-dummy.png" alt="recipe-image">
        <input type="file" name="image" class="border border-gray-300 p-2 mb-4 w-full rounded">
      </div>
      <div class="col-span-1 p-4">
        <input type="text" name="title" placeholder="レシピ名" class="border border-gray-300 p-2 mb-4 w-full rounded">
        <textarea name="description" placeholder="レシピの説明"
          class="border border-gray-300 p-2 mb-4 w-full rounded"></textarea>
        <select name="category" class="border border-gray-300 p-2 mb-4 w-full rounded">
          <option value="">カテゴリー</option>
          @foreach($categories as $c)
          <option value="{{$c['id']}}">{{$c['name']}}</option>
          @endforeach
        </select>
        <div class="flex justify-end">
          <button type="submit"
            class="text-white bg-green-500 hover:bg-green-700 font-bold px-4 rounded py-2">レシピを投稿する</button>
        </div>
      </div>
      <hr class="my-4">
      <h4 class="text-center text-xl">手順を入力</h4>
      <div id="steps">
        @for($i = 1; $i < 4; $i++) <div class="step flex justify-between">
          @include('components.bars-3')
          <p class="step-number">手順{{$i}}</p>
          <input type="text" name="steps[]" placeholder="手順を入力" class="border border-gray-300 p-2 mb-4 w-full rounded">
          @include('components.dust')
      </div>
      @endfor
    </div>
    </div>
  </form>
</x-app-layout>
