<div class="flex items-center gap-4">
    @if ($image = $getState())
        <img src="{{ Storage::disk('public')->url($image) }}" 
             style="max-width:200px;max-height:128px;object-fit:contain" 
             alt="商品圖片" />
    @endif
</div>