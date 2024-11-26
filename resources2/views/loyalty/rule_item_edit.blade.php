<div class="modal edit-second-part" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
        <div class="modal-content modal-conting-blog">

            <div class="modal-body modal-inner-blog">
                <h6>Seleted Items </h6>
                <div class="content">
                    <div class="table-scroll-y-blog table-active-blog">
                        <table class="table-inner-sec">
                            @foreach ($categories as $item)
                                <tbody class="t-b-blog">
                                    <tr class="odd">
                                        <td class="edit-category table-tag-blog">
                                            <div>
                                                <input type="checkbox" class="selectall inner-checkin-blog"
                                                    data-category-id="{{ $item->category_id }}"
                                                    id="modifier-group-{{ $item->category_id }}"
                                                    @if (in_array($item->category_id, $categoryIds)) checked @endif>
                                            </div>
                                        </td>
                                        <td class="forum-topic-blog">{{ $item->category_name }}</td>
                                    </tr>
                                    @foreach ($item->category_item as $menuItem)
                                        <tr class="even">
                                            <td class="edit-menu table-tag">
                                                <div
                                                    class="form-item form-type-checkbox form-item-node-types-forum subOption">
                                                    <input type="checkbox" id="edit-node-types-forum"
                                                        name="modifier_item" value="forum"
                                                        class="form-checkbox individual inner-checkin-blog item-group-{{ $menuItem->category_id }}"
                                                        data-item-id={{ $menuItem->menu_id }}
                                                        data-category-id="{{ $menuItem->category_id }}"
                                                        @if (in_array($menuItem->menu_id, $itemIds)) checked @endif>
                                                </div>
                                            </td>
                                            <td class="forum-topic-blog">
                                                {{ $menuItem->item_name }}
                                            </td>
                                            <td class="forum-blog">
                                                <small>${{ number_format($menuItem->item_price, 2) }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer-blog">
                <button type="button" class="btn btn-first second-close edit-count-item">Add </button>
                <button type="button" class="btn btn-second second-cancle-in edit-modifier-modal">Cancel</button>
            </div>

        </div>
    </div>
</div>
