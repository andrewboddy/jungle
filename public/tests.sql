select ticker
from stocks
where long_description like '%Mexico%'
or  long_description like '%India%'
or  long_description like '%China%'
or  long_description like '%Pakistan%'
or  long_description like '%Canada%'
or  long_description like '%Brazil%'
or  long_description like '%Argentina%'
or  long_description like '%Germany%'
or  long_description like '%Russia%'
or  long_description like '%Spain%'
or  long_description like '%Chile%'
or  long_description like '%Korea%'
or  long_description like '%United Kingdom%'
or  long_description like '%Australia%'
or  long_description like '%Europe%'
or  long_description like '%Asia%'
or  long_description like '%Africa%'
or  long_description like '%internation%'
or  long_description like '%Japan%';



select  sector, industry, ticker, name ,pe_ttm, pe_f1, pe_f2 from stocks  where industry='Communication - Network Software' LIMIT 10;

mysql> desc industries;
+----------+------------------+------+-----+---------+----------------+
| Field    | Type             | Null | Key | Default | Extra          |
+----------+------------------+------+-----+---------+----------------+
| id       | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| sector   | varchar(191)     | NO   |     | NULL    |                |
| industry | varchar(191)     | NO   |     | NULL    |                |
| pe0      | tinyint(4)       | NO   |     | NULL    |                |
| pe1      | tinyint(4)       | NO   |     | NULL    |                |
| pe2      | tinyint(4)       | NO   |     | NULL    |                |
| eps0     | decimal(5,2)     | NO   |     | NULL    |                |
| eps1     | decimal(5,2)     | NO   |     | NULL    |                |
| eps2     | decimal(5,2)     | NO   |     | NULL    |                |
| g1       | decimal(8,2)     | NO   |     | NULL    |                |
| g2       | decimal(8,2)     | NO   |     | NULL    |                |
| peg1     | decimal(5,2)     | NO   |     | NULL    |                |
| peg2     | decimal(5,2)     | NO   |     | NULL    |                |
| notes    | varchar(191)     | NO   |     | NULL    |                |
+----------+------------------+------+-----+---------+----------------+

+---------------------------+------------------+------+-----+---------+----------------+
| Field                     | Type             | Null | Key | Default | Extra          |
+---------------------------+------------------+------+-----+---------+----------------+
| id                        | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| created_at                | timestamp        | YES  |     | NULL    |                |
| updated_at                | timestamp        | YES  |     | NULL    |                |
| ticker                    | varchar(191)     | NO   |     | NULL    |                |
| name                      | varchar(191)     | NO   |     | NULL    |                |
| sector                    | varchar(191)     | NO   |     | NULL    |                |
| industry                  | varchar(191)     | NO   |     | NULL    |                |
| mkt_cap                   | decimal(8,2)     | NO   |     | NULL    |                |
| exchange                  | varchar(191)     | NO   |     | NULL    |                |
| eps_f0                    | decimal(8,2)     | NO   |     | NULL    |                |
| eps_f1                    | decimal(8,2)     | NO   |     | NULL    |                |
| eps_f2                    | decimal(8,2)     | NO   |     | NULL    |                |
| pe_ttm                    | decimal(8,2)     | NO   |     | NULL    |                |
| pe_f1                     | decimal(8,2)     | NO   |     | NULL    |                |
| pe_f2                     | decimal(8,2)     | NO   |     | NULL    |                |
| peg_ratio                 | decimal(8,2)     | NO   |     | NULL    |                |
| div_yield                 | decimal(8,2)     | NO   |     | NULL    |                |
| net_margin                | decimal(8,2)     | NO   |     | NULL    |                |
| change_f1_est_4_weeks     | decimal(8,2)     | NO   |     | NULL    |                |
| change_f2_est_4_weeks     | decimal(8,2)     | NO   |     | NULL    |                |
| change_ltg_est_4_weeks    | decimal(6,2)     | NO   |     | NULL    |                |
| last_eps_surprise         | decimal(8,2)     | NO   |     | NULL    |                |
| prev_eps_surprise         | decimal(8,2)     | NO   |     | NULL    |                |
| avg_eps_surprise_last_4_q | decimal(8,2)     | NO   |     | NULL    |                |
| next_earnings_call        | int(11)          | NO   |     | NULL    |                |
| year_end                  | int(11)          | NO   |     | NULL    |                |
| debt_total_capital        | decimal(7,5)     | NO   |     | NULL    |                |
| growth1                   | decimal(8,2)     | NO   |     | NULL    |                |
| growth2                   | decimal(8,2)     | NO   |     | NULL    |                |
| growth_story              | varchar(191)     | NO   |     | NULL    |                |
| exclude                   | tinyint(1)       | NO   |     | NULL    |                |
| long_x_short              | tinyint(4)       | NO   |     | NULL    |                |
+---------------------------+------------------+------+-----+---------+----------------+

update stocks set long_x_short=1 where growth1>0;
update stocks set long_x_short=0 where growth1=0;
update stocks set long_x_short=-1 where growth1<0;

delete from industries;

insert into industries  (
	select null, sector, industry
		,round(avg(pe_ttm))
		,round(avg(pe_f1))
		,round(avg(pe_f2))
		,round(avg(eps_f0), 2)
		,round(avg(eps_f1), 2)
		,round(avg(eps_f2), 2)
		,0,0
		,0,0
		,null
	from stocks  
	where long_x_short = 1
	group by sector, industry);

update industries 
	set g1 = round((eps1/eps0)-1, 2)
	   ,g2 = round((eps2/eps1)-1, 2);

update industries 
	set peg1 = round( (pe1/g1), 2)
	   ,peg2 = round( (pe2/g2)-1, 2);

==============

--
	select null, sector, industry
		,0,0
		,long_x_short
	from stocks  
	where long_x_short = 1
	and industry = "internet - Services"
	group by sector, industry;



	select null, sector, industry
		,round(avg(pe_ttm))
		,0,0
		,long_x_short as x
	from stocks  
	group by sector, industry
	having x = 1;


	select null, sector, industry
		,round(avg(pe_ttm))
		,0,0
		,long_x_short as x
	from stocks  
	group by sector, industry;


update industries 
	set eps0 = avg()
	,eps1
	,eps2


insert into industries select null, sector, industry, round(avg(pe_ttm)),round(avg(pe_f1)), round(avg(pe_f2)) from stocks  group by sector, industry;

update industries set eps0 = round(avg(eps_f0),2)



select  sector, industry, round(avg(eps_f0),2),round(avg(eps_f1),2), round(avg(eps_f2),2) 
from stocks  
group by sector, industry, long_x_short 
LIMIT 10;






