<!DOCTYPE html>
<html>
<head>
    <title>FarmingActivities</title>
    <style>
        body {
            margin: 0;
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 440;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #ffffff;
        }

        .input-group {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
    </style>
</head>
<body>
    <p style="text-align: right; font-size: 10pt;">Date Report Generated: 2022-4-17&nbsp;</p>
    <hr style="width: 1000px; margin-left: -200px; margin-top: -16px">
    <div>
        <p style="text-align: center; font-size: 12pt; margin: 0;"><strong><span   >PROPOSED SYSTEM</span></strong></p>
        <p style="text-align: center; font-size: 10pt; margin: 0;"><span >Report on Farming Activity of Every Farmer</span></p>
        <p style="text-align: center; font-size: 10pt; margin: 0;"><span >in Barangay {{$jsbrgy}} in Year {{$jsyear}}</span></p>
    </div>

    <p style="text-align: center; margin-bottom: 5px; margin-top: 20px;"><span style="font-size: 15pt;">Farming Activity</span></p>
    
    <table style="width: 100%; border-collapse: collapse; border: 1px inset rgb(0, 0, 0); ">
        <tbody>
            <tr>
                <td style="width: 13.7782%; border: 1px inset rgb(0, 0, 0);">
                    <div style="text-align: center;"><span style="font-size: 14px;">Farmer</span></div>
                </td>
                <td style="width: 8.4527%; border: 1px inset rgb(0, 0, 0);">
                    <div style="text-align: center;"><span style="font-size: 14px;">Crops</span></div>
                </td>
                <td style="width: 77.6505%; border: 1px inset rgb(0, 0, 0);">
                    <div data-empty="true" style="text-align: center;">
                        <span style="font-size: 14px; ">Water</span> - <span style="width: 5%; background-color: rgba(117, 190, 218, 0.5); color: rgba(117, 190, 218); user-select:none;">___</span>
                        <span style="font-size: 14px; ">Fertilizer</span> - <span style="width: 5%; background-color:rgba(75, 192, 192, 0.5); color: rgba(75, 192, 192); user-select:none;">___</span>
                        <span style="font-size: 14px; ">Pesticide</span> - <span style="width: 5%; background-color: rgba(153, 102, 255, 0.5); color: rgba(153, 102, 255); user-select:none;">___</span>
                    </div>
                </td>
            </tr>
            @foreach($FA_counts as $key1 => $FA_count)
                @if($FA_counts[$key1] != 0)
                    <tr>
                        <td style="width: 13.7782%; border: 1px inset rgb(0, 0, 0);">
                            <div data-empty="true" style="text-align: center;"><span style="font-size: 14px;">{{$Farmers[$key1]}}</span></div>
                        </td>
                        <td style="width: 8.4527%; border: 1px inset rgb(0, 0, 0);">
                            <div data-empty="true" style="text-align: center;"><span style="font-size: 14px;">{{$N_crops[$key1]}}</span></div>
                        </td>
                        <td style="width: 77.6505%; border: 1px inset rgb(0, 0, 0);">
                        <table style="width: 100%;">
                            <tbody>
                                <tr style="width: 100%; text-align: center;">
                                    <td style="width: {{$FA_percents[$key1][0]}}%; background-color: rgba(117, 190, 218, 0.5);">{{$FA_percents[$key1][0]}}% ({{$FA_counts[$key1][0]}})</td>
                                    <td style="width: {{$FA_percents[$key1][1]}}%; background-color: rgba(75, 192, 192, 0.5);">{{$FA_percents[$key1][1]}}% ({{$FA_counts[$key1][1]}})</td>
                                    <td style="width: {{$FA_percents[$key1][2]}}%; background-color: rgba(153, 102, 255, 0.5);">{{$FA_percents[$key1][2]}}% ({{$FA_counts[$key1][2]}})</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <p style="text-align: center; margin-bottom: 5px; margin-top: 20px;"><span style="font-size: 15pt;">Detailed</span></p>
    
    <table style="width: 100%; border-collapse: collapse; border: 1px inset rgb(0, 0, 0); ">
        <thead>
            <tr>
                <td style="width: 13.7782%; border: 1px inset rgb(0, 0, 0);">
                    <div style="text-align: center;"><span style="font-size: 14px;">Farmer</span></div>
                </td>
                <td style="width: 13.6781%; border: 1px inset rgb(0, 0, 0);">
                    <div style="text-align: center;"><span style="font-size: 14px;">Crop</span></div>
                </td>
                <td style="width: 72.4267%; border: 1px inset rgb(0, 0, 0);">
                    <div data-empty="true" style="text-align: center;">
                        <span style="font-size: 14px; ">Activity</span>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach($FA_counts as $key1 => $FA_count)
                @if($FA_counts[$key1] != 0)
                    @for($i = 0; $i <= $FD_counters[$key1]-1; $i++)
                        <tr>
                            <td style="width: 13.7782%; border: 1px inset rgb(0, 0, 0);">
                                <div data-empty="true" style="text-align: center;">
                                    <span style="font-size: 14px;">
                                        @if($i == 0)
                                            {{$Farmers[$key1]}}
                                        @endif 
                                    </span>
                                </div>
                            </td>
                            <td style="width: 8.4527%; border: 1px inset rgb(0, 0, 0);">
                                <div data-empty="true" style="text-align: center;"><span style="font-size: 14px;">{{$FD_crops[$key1][$i]->crop->name}}</span></div>
                            </td>
                            <td style="width: 77.6505%; border: 1px inset rgb(0, 0, 0);">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="width: 100%; text-align: center;">
                                        <td style="width: {{$FD_percents[$key1][$i][0]}}%; background-color: rgba(117, 190, 218, 0.5);">{{$FD_percents[$key1][$i][0]}}% ({{$FD_counts[$key1][$i][0]}})</td>
                                        <td style="width: {{$FD_percents[$key1][$i][1]}}%; background-color: rgba(75, 192, 192, 0.5);">{{$FD_percents[$key1][$i][1]}}% ({{$FD_counts[$key1][$i][1]}})</td>
                                        <td style="width: {{$FD_percents[$key1][$i][2]}}%; background-color: rgba(153, 102, 255, 0.5);">{{$FD_percents[$key1][$i][2]}}% ({{$FD_counts[$key1][$i][2]}})</td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                    @endfor
                @endif
            @endforeach
        </tbody>
    </table>
    <p style="margin-bottom: 5px; margin-top: 70px;"><span style="font-size: 10pt;">Verified by:</span></p>
    <p style="margin-bottom: 0px; margin-top: 5px;"><span style="font-size: 10pt;">{{$technician}}</span></p>
    <p style="margin-bottom: 5px; margin-top: 0px;"><span style="font-size: 8pt;">Technician</span></p>
</body>
</html>