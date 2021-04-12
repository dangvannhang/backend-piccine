<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\Detail_Booking;
use App\Http\Requests\BookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Hiển thị tất cả các lịch booking từ mới tới cũ, giới hạn show ra theo page, mỗi page chỉ có 5 booking schedule
    public function index()
    {
        //
        // $booking = new Booking;
        $booking = Booking::latest()->get();

        return response()->json($booking);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        //
        $booking = new Booking;
        $booking -> id_user = $request -> id_user;
        $booking -> id_photographer = $request -> id_photographer;
        $booking -> id_combo = $request -> id_combo;
        $booking -> is_cancel = $request -> is_cancel;
        $booking -> id_voucher = $request -> id_voucher;
        $booking -> save();

        $id_booking = $booking->id;
        $detail_booking = new Detail_Booking;
        $detail_booking -> id_booking = $id_booking;
        $detail_booking -> address = $request -> address;
        $detail_booking -> start_time = $request -> start_time;
        $detail_booking -> end_time = $request -> end_time;
        $detail_booking -> price = $request -> price;

        $detail_booking -> save();
        return response()->json($booking);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $booking=Booking::find($id);
        return response()->json($booking);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // update dùng ở đây để người dùng có thể thay đổi combo hay thời gian đặt vậy đó.
    // public function update(Request $request, $id)
    // {
    //     //
    //     $booking=Booking::findOrFail($id);
    //     $booking->is_cancel='false';
    //     $booking->code_voucher="Editbooking122";
    //     $booking->save();
    //     // hiện đang không thể $request tới các trường ở input, nên phải fix data để tét
    //     // $booking->save();

    //     return response()->json($booking);
    // }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $booking=Booking::find($id);
        $booking->delete();

        return response()->json("Delete finished");
    }


    //  Khi mà người dùng không muốn đặt lịch book nữa thì họ có thể cancel nhưng cái lịch booking vẫn lưu lại, chỉ chuyển is_cancel thành false
    public function cancel_booking($id, Request $request) {
        $booking=Booking::find($id);

        $booking->is_cancel=1;
        $booking->save();

        return response()->json($booking);
    }

    // Hiển thị các booking schedule đã bị hủy
    public function show_cancel_booking() {
        $booking = Booking::where('is_cancel',1)->get();
        return response()->json($booking);
    }

}
