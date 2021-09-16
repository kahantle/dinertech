            @foreach ($modifiers as $item)
            <div class="order">
              <div class="collapsed a-order" data-toggle="collapse" href="#collapseOne{{$item->modifier_group_name}}">
                <div class="order-name">
                  <div class="circle"></div>
                  <h4>{{$item->modifier_group_name}}<a href="javaScript:Void(0);" class="ml-1 badge badge-info">{{$item->modifier_item->count()}}</a>
                  </h4>
                </div>
                <div class="order-detail">
                  <a href="#modifierItem" class="openModifierItemForm open" data-id={{$item->modifier_group_id}}>Add Item <i class="fa fa-plus" aria-hidden="true"></i></a>
                  <div class="order-icons">
                    <a  data-route="{{route('edit.menu.modifier.post',[$item->modifier_group_id])}}" href="javaScript:Void(0);" class="openModifierForm action-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a  data-route="{{route('delete.menu.modifier.post',[$item->modifier_group_id])}}" href="javaScript:Void(0);" class="delete  action-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
              <div id="collapseOne{{$item->modifier_group_name}}" class="collapse c-order" data-parent="#accordion" >
               @foreach ($item->modifier_item as $item)
               <div class="child">
                <div class="order-name">
                  <div class="circle"></div>
                  <h4>{{$item->modifier_group_item_name}}</h4>
                </div>
                <div class="order-detail">
                  <div class="number">
                    <p>{{$item->modifier_group_item_price}}</p>
                  </div>
                  <div class="order-icons">
                    <a  data-route="{{route('edit.modifier.item.post',$item->modifier_item_id)}}" href="javaScript:Void(0);" class="openModifierItemForm action-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a  data-route="{{route('delete.menu.modifier.item.post',[$item->modifier_item_id])}}" href="javaScript:Void(0);" class="delete action-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach