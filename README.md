# application-tier-php
Studi kasus pengembangan aplikasi perangkat lunak desktop cross-platform dengan pendekatan <b>3-Tier Architecture Pattern</b> (client-tier, application-tier, data-tier) dan <b>Layered Architecture Pattern</b> (presentation layer, business logic layer, data access layer, data source layer).

<h3>3-Tier Architecture Pattern</h3>
<ol>
  <li><b>Client-Tier (Java Swing)</b> https://github.com/fachrulpbm/client-tier-swing</li>
    <ul>
      <li><b>Presentation Layer</b> (MVC Pattern)</li>
        <ul>
          <li>model</li>
          <li>view</li>
          <li>controller</li>
          <li>worker (background thread)</li>
          <li>api</li>
        </ul>
    </ul>
  <li><b>Application-Tier (PHP Native)</b> https://github.com/fachrulpbm/application-tier-php</li>
    <ul>
      <li><b>Business Logic Layer</b> (Service Layer Pattern)</li>
        <ul>
          <li>services</li>
          <li>core/App</li>
          <li>core/Controller</li>
          <li>controllers</li>
        </ul>
      <li><b>Data Access Layer</b> (DAO Pattern)</li>
        <ul>
          <li>core/Model</li>
          <li>models</li>
          <li>config</li>
        </ul>
    </ul>
  <li><b>Data-Tier (DBMS MySQL)</b> https://github.com/fachrulpbm/data-tier-mysql</li>
    <ul>
      <li><b>Data Source Layer</b></li>
        <ul>
          <li>Database Engine</li>
        </ul>
    </ul>
</ol>
