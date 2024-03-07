@extends('layouts.default')

@section('page-title')

@stop

@section('content')
    <table class='table table-bordered' style="table-layout: fixed;">
        <tr>
            <th colspan="<?php echo NUMBER_OF_COLUMNS; ?>" class="text-center"> <?php echo $title; ?> <?php echo $year; ?> </th>
        </tr>
        <tr>
            <?php foreach($weekDays as $key => $weekDay) : ?>
            <td class="text-center"><?php echo $weekDay; ?></td>
            <?php endforeach ?>
        </tr>
        <tr>
            <?php for($i = 0; $i < $blank; $i++): ?>
            <td></td>
            <?php endfor; ?>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php if($day == $i): ?>
            <td><strong><?php echo $i; ?></strong></td>
            <?php else: ?>
            <td><?php echo $i; ?></td>
            <?php endif; ?>
            <?php if(($i + $blank) % NUMBER_OF_COLUMNS == 0): ?>
        </tr>
        <tr>
            <?php endif; ?>
            <?php endfor; ?>
            <?php for($i = 0; ($i + $blank + $daysInMonth) % NUMBER_OF_COLUMNS != 0; $i++): ?>
            <td></td>
            <?php endfor; ?>
        </tr>
    </table>

@stop
