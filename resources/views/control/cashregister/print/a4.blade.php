<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('cashregister.reports.title') }}</title>

    <style type="text/css">

body {
  font-size: small;
  line-height: 1.4;
}
p {
  margin: 0;
}

.performance-facts {
  border: 1px solid black;
  margin: 30px;
  float: left;
  width: 90%;
  padding: 0.5rem;
  table {
    border-collapse: collapse;
  }
}
.performance-facts__title {
  font-weight: bold;
  font-size: 2rem;
  margin: 0 0 0.25rem 0;
}
.performance-facts__header {
  border-bottom: 10px solid black;
  padding: 0 0 0.25rem 0;
  margin: 0 0 0.5rem 0;
  p {
    margin: 0;
  }
}
.performance-facts__table {
  width: 100%;
  thead tr {
    th,
    td {
      border: 0;
    }
  }
  th,
  td {
    font-weight: normal;
    text-align: left;
    padding: 0.25rem 0;
    border-top: 1px solid black;
    white-space: nowrap;
  }
  td {
    &:last-child {
      text-align: right;
    }
  }
  .blank-cell {
    width: 1rem;
    border-top: 0;
  }
  .thick-row {
    th,
    td {
      border-top-width: 5px;
    }
  }
}
.small-info {
  font-size: 0.7rem;
}

.performance-facts__table--small {
  @extend .performance-facts__table;
  border-bottom: 1px solid #999;
  margin: 0 0 0.5rem 0;
  thead {
    tr {
      border-bottom: 1px solid black;
    }
  }
  td {
    &:last-child {
      text-align: left;
    }
  }
  th,
  td {
    border: 0;
    padding: 0;
  }
}

.performance-facts__table--grid {
  @extend .performance-facts__table;
  margin: 0 0 0.5rem 0;
  td {
    &:last-child {
      text-align: left;
      &::before {
        content: "•";
        font-weight: bold;
        margin: 0 0.25rem 0 0;
      }
    }
  }
}

.text-center {
  text-align: center;
}
.thick-end {
  border-bottom: 10px solid black;
}
.thin-end {
  border-bottom: 1px solid black;
}


    </style>
</head>
<body>


<section class="performance-facts">
  <header class="performance-facts__header">
    <h1 class="performance-facts__title">{{ __('cashregister.reports.subtitle', ['business' => $data['business']['name']]) }}</h1>
    <p>{{ __('cashregister.reports.date', ['date' => $data['date']]) }}</p>
      <p>{{ __('cashregister.reports.user', ['user' => $data['user']->name]) }}</p>
  </header>
  @php
      $incomes = $data['incomes'];
      $expenses = $data['expenses'];
      $cash = $data['cash'];
      $cards = $data['cards'];
      $deposits = $data['deposits'];
  @endphp
  <table class="performance-facts__table">
    <tbody>
      <tr>
        <th colspan="2">
          <b>{{ __('cashregister.general.incomes') }}</b>
        </th>
        <td>
          <b>{{ $incomes->sum('amount') }}</b>
        </td>
      </tr>
      @foreach ($incomes as $item)
        <tr>
          <td class="blank-cell">
          </td>
          <th>
            {{$item->concept->name}}
          </th>
          <td>
            <b>{{ $item->amount }}</b>
          </td>
        </tr>
      @endforeach
      <br>
      <tr>
        <th colspan="2">
          <b>{{ __('cashregister.general.expenses') }}</b>
        </th>
        <td>
          <b>{{ $expenses->sum('amount') }}</b>
        </td>
      </tr>
      @foreach ($expenses as $item)
        <tr>
          <td class="blank-cell">
          </td>
          <th>
            {{$item->concept->name}}
          </th>
          <td>
            <b>{{ $item->amount }}</b>
          </td>
        </tr>
      @endforeach
      <br>
      <tr>
        <th colspan="2">
          <b>{{ __('cashregister.general.cash') }}</b>
        </th>
        <td>
          <b>{{ $cash }}</b>
        </td>
      </tr>
      <br>
      <tr>
        <th colspan="2">
          <b>{{ __('cashregister.general.card') }}</b>
        </th>
        <td>
          <b>{{ $cards }}</b>
        </td>
      </tr>
      <br>
      <tr>
        <th colspan="2">
          <b>{{ __('cashregister.general.deposit') }}</b>
        </th>
        <td>
          <b>{{ $deposits }}</b>
        </td>
      </tr>
    </tbody>
  </table>

  <p class="small-info text-center">
    {{ $data['date'] }} 
  </p>

</section>
</body>
</html>