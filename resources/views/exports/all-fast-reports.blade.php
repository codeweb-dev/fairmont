<table>
    <thead>
        <tr>
            <th>Report Type</th>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Voyage No</th>
            <th>Port</th>
            <th>Date</th>
            <th>HSFO</th>
            <th>BIOFUEL</th>
            <th>VLSFO</th>
            <th>LSMGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            @foreach($report->robs as $rob)
                <tr>
                    <td>{{ $report->report_type }}</td>
                    <td>{{ $report->vessel->name }}</td>
                    <td>{{ $report->unit->name }}</td>
                    <td>{{ $report->voyage_no }}</td>
                    <td>{{ $report->port }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
                    <td>{{ $rob->hsfo ?? '0' }}</td>
                    <td>{{ $rob->biofuel ?? '0' }}</td>
                    <td>{{ $rob->vlsfo ?? '0' }}</td>
                    <td>{{ $rob->lsmgo ?? '0' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
