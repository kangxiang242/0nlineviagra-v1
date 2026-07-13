@foreach($data as $v)
    <div class="store-item" >
        <input class="form-radio" type="radio" {{ count($data)<=1?"checked":"" }} id="store-{{ $v['shop_no'] }}" name="store_id" value="{{ $v['shop_no'] }}">
        <label class="marquee" for="store-{{ $v['shop_no'] }}">
            <span class="dress"></span>
            <div class="store-info icon-711">
                <p class="store-name">{{ $v['shop_name'] }}<span class="store-address">（{{ $v['shop_address'] }}）</span></p>

            </div>
        </label>
    </div>
@endforeach
