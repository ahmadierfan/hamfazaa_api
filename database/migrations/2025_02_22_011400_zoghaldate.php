<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION `__mydiv`(`a` int, `b` int) RETURNS bigint(20)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                RETURN FLOOR(a / b);
            END;
        ');


        DB::unprepared('
            CREATE FUNCTION `__mymod`(`a` int, `b` int) RETURNS bigint(20)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                RETURN (a - b * FLOOR(a / b));
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `_gdmarray`(`m` smallint) RETURNS smallint(2)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                CASE m
                    WHEN 0 THEN RETURN 31;
                    WHEN 1 THEN RETURN 28;
                    WHEN 2 THEN RETURN 31;
                    WHEN 3 THEN RETURN 30;
                    WHEN 4 THEN RETURN 31;
                    WHEN 5 THEN RETURN 30;
                    WHEN 6 THEN RETURN 31;
                    WHEN 7 THEN RETURN 31;
                    WHEN 8 THEN RETURN 30;
                    WHEN 9 THEN RETURN 31;
                    WHEN 10 THEN RETURN 30;
                    WHEN 11 THEN RETURN 31;
                END CASE;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `_jdmarray`(`m` smallint) RETURNS smallint(2)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                CASE m
                    WHEN 0 THEN RETURN 31;
                    WHEN 1 THEN RETURN 31;
                    WHEN 2 THEN RETURN 31;
                    WHEN 3 THEN RETURN 31;
                    WHEN 4 THEN RETURN 31;
                    WHEN 5 THEN RETURN 31;
                    WHEN 6 THEN RETURN 30;
                    WHEN 7 THEN RETURN 30;
                    WHEN 8 THEN RETURN 30;
                    WHEN 9 THEN RETURN 30;
                    WHEN 10 THEN RETURN 30;
                    WHEN 11 THEN RETURN 29;
                END CASE;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `_jdmarray2`(`m` smallint) RETURNS smallint(2)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                CASE m
                    WHEN 1 THEN RETURN 31;
                    WHEN 2 THEN RETURN 31;
                    WHEN 3 THEN RETURN 31;
                    WHEN 4 THEN RETURN 31;
                    WHEN 5 THEN RETURN 31;
                    WHEN 6 THEN RETURN 31;
                    WHEN 7 THEN RETURN 30;
                    WHEN 8 THEN RETURN 30;
                    WHEN 9 THEN RETURN 30;
                    WHEN 10 THEN RETURN 30;
                    WHEN 11 THEN RETURN 30;
                    WHEN 12 THEN RETURN 29;
                END CASE;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `pdate`(`gdate` datetime) RETURNS char(100) CHARSET utf8
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i,
                    gy, gm, gd,
                    g_day_no, j_day_no, j_np,jy INT DEFAULT 0;
                DECLARE jm, jd INT(2) ZEROFILL DEFAULT 0;
                DECLARE resout char(100);
                DECLARE ttime CHAR(20);

                SET gy = YEAR(gdate) - 1600;
                SET gm = MONTH(gdate) - 1;
                SET gd = DAY(gdate) - 1;
                SET ttime = TIME(gdate);
                SET g_day_no = ((365 * gy) + __mydiv(gy + 3, 4) - __mydiv(gy + 99, 100) + __mydiv (gy + 399, 400));
                SET i = 0;

                WHILE (i < gm) do
                    SET g_day_no = g_day_no + _gdmarray(i);
                    SET i = i + 1;
                END WHILE;

                IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN
                    SET g_day_no = g_day_no + 1;
                END IF;

                SET g_day_no = g_day_no + gd;
                SET j_day_no = g_day_no - 79;
                SET j_np = j_day_no DIV 12053;
                SET j_day_no = j_day_no % 12053;
                SET jy = 979 + 33 * j_np + 4 * __mydiv(j_day_no, 1461);
                SET j_day_no = j_day_no % 1461;

                IF j_day_no >= 366 then
                    SET jy = jy + __mydiv(j_day_no - 1, 365);
                    SET j_day_no = (j_day_no - 1) % 365;
                END IF;

                SET i = 0;

                WHILE (i < 11 and j_day_no >= _jdmarray(i)) do
                    SET j_day_no = j_day_no - _jdmarray(i);
                    SET i = i + 1;
                END WHILE;

                SET jm = i + 1;
                SET jd = j_day_no + 1;
                SET resout = CONCAT_WS (\'-\', jy, jm, jd);

                IF (ttime <> \'00:00:00\') then
                    SET resout = CONCAT_WS(\' \', resout, ttime);
                END IF;

                RETURN resout;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `PMONTH`(`gdate` datetime) RETURNS char(100) CHARSET utf8
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i,
                    gy, gm, gd,
                    g_day_no, j_day_no, j_np,
                    jy, jm, jd INT DEFAULT 0;

                SET gy = YEAR(gdate) - 1600;
                SET gm = MONTH(gdate) - 1;
                SET gd = DAY(gdate) - 1;
                SET g_day_no = ((365 * gy) + __mydiv(gy + 3, 4) - __mydiv(gy + 99, 100) + __mydiv(gy + 399, 400));
                SET i = 0;

                WHILE (i < gm) do
                    SET g_day_no = g_day_no + _gdmarray(i);
                    SET i = i + 1;
                END WHILE;

                IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN
                    SET g_day_no = g_day_no + 1;
                END IF;

                SET g_day_no = g_day_no + gd;
                SET j_day_no = g_day_no - 79;
                SET j_np = j_day_no DIV 12053;
                set j_day_no = j_day_no % 12053;
                SET jy = 979 + 33 * j_np + 4 * __mydiv(j_day_no, 1461);
                SET j_day_no = j_day_no % 1461;

                IF j_day_no >= 366 then
                    SET jy = jy + __mydiv(j_day_no - 1, 365);
                    SET j_day_no =(j_day_no - 1) % 365;
                END IF;

                SET i = 0;

                WHILE (i < 11 and j_day_no >= _jdmarray(i)) do
                    SET j_day_no = j_day_no - _jdmarray(i);
                    SET i = i + 1;
                END WHILE;

                SET jm = i + 1;
                SET jd = j_day_no + 1;
                RETURN jm;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `pmonthname`(`gdate` datetime) RETURNS varchar(100) CHARSET utf8
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                CASE PMONTH(gdate)
                    WHEN 1 THEN RETURN \'فروردین\';
                    WHEN 2 THEN RETURN \'اردیبهشت\';
                    WHEN 3 THEN RETURN \'خرداد\';
                    WHEN 4 THEN RETURN \'تیر\';
                    WHEN 5 THEN RETURN \'مرداد\';
                    WHEN 6 THEN RETURN \'شهریور\';
                    WHEN 7 THEN RETURN \'مهر\';
                    WHEN 8 THEN RETURN \'آبان\';
                    WHEN 9 THEN RETURN \'آذر\';
                    WHEN 10 THEN RETURN \'دی\';
                    WHEN 11 THEN RETURN \'بهمن\';
                    WHEN 12 THEN RETURN \'اسفند\';
                END CASE;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `pyear`(`gdate` datetime) RETURNS char(100) CHARSET utf8
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i,
                    gy, gm, gd,
                    g_day_no, j_day_no, j_np,
                    jy, jm, jd INT DEFAULT 0;

                SET gy = YEAR(gdate) - 1600;
                SET gm = MONTH(gdate) - 1;
                SET gd = DAY(gdate) - 1;
                SET g_day_no = ((365 * gy) + __mydiv(gy + 3, 4) - __mydiv(gy + 99, 100) + __mydiv(gy + 399, 400));
                SET i = 0;

                WHILE (i < gm) do
                    SET g_day_no = g_day_no + _gdmarray(i);
                    SET i = i + 1;
                END WHILE;

                IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN
                    SET g_day_no = g_day_no + 1;
                END IF;

                SET g_day_no = g_day_no + gd;
                SET j_day_no = g_day_no - 79;
                SET j_np = j_day_no DIV 12053;
                set j_day_no = j_day_no % 12053;
                SET jy = 979 + 33 * j_np + 4 * __mydiv(j_day_no, 1461);
                SET j_day_no = j_day_no % 1461;

                IF j_day_no >= 366 then
                    SET jy = jy + __mydiv(j_day_no - 1, 365);
                    SET j_day_no = (j_day_no - 1) % 365;
                END IF;

                SET i = 0;

                WHILE (i < 11 and j_day_no >= _jdmarray(i)) do
                    SET j_day_no = j_day_no - _jdmarray(i);
                    SET i = i + 1;
                END WHILE;

                SET jm = i + 1;
                SET jd = j_day_no + 1;
                RETURN jy;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `pday`(`gdate` datetime) RETURNS char(100) CHARSET utf8
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i,
                    gy, gm, gd,
                    g_day_no, j_day_no, j_np,
                    jy, jm, jd INT DEFAULT 0;

                SET gy = YEAR(gdate) - 1600;
                SET gm = MONTH(gdate) - 1;
                SET gd = DAY(gdate) - 1;
                SET g_day_no = ((365 * gy) + __mydiv(gy + 3, 4) - __mydiv(gy + 99 , 100) + __mydiv(gy + 399, 400));
                SET i = 0;

                WHILE (i < gm) do
                    SET g_day_no = g_day_no + _gdmarray(i);
                    SET i = i + 1;
                END WHILE;

                IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN
                    SET g_day_no = g_day_no + 1;
                END IF;

                SET g_day_no = g_day_no + gd;
                SET j_day_no = g_day_no - 79;
                SET j_np = j_day_no DIV 12053;
                SET j_day_no = j_day_no % 12053;
                SET jy = 979 + 33 * j_np + 4 * __mydiv(j_day_no, 1461);
                SET j_day_no = j_day_no % 1461;

                IF j_day_no >= 366 then
                    SET jy = jy + __mydiv(j_day_no - 1, 365);
                    SET j_day_no = (j_day_no-1) % 365;
                END IF;

                SET i = 0;

                WHILE (i < 11 and j_day_no >= _jdmarray(i)) do
                    SET j_day_no = j_day_no - _jdmarray(i);
                    SET i = i + 1;
                END WHILE;

                SET jm = i + 1;
                SET jd = j_day_no + 1;
                RETURN jd;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `_gdmarray2`(`m` smallint, `k` SMALLINT) RETURNS smallint(2)
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                CASE m
                    WHEN 0 THEN RETURN 31;
                    WHEN 1 THEN RETURN 28+k;
                    WHEN 2 THEN RETURN 31;
                    WHEN 3 THEN RETURN 30;
                    WHEN 4 THEN RETURN 31;
                    WHEN 5 THEN RETURN 30;
                    WHEN 6 THEN RETURN 31;
                    WHEN 7 THEN RETURN 31;
                    WHEN 8 THEN RETURN 30;
                    WHEN 9 THEN RETURN 31;
                    WHEN 10 THEN RETURN 30;
                    WHEN 11 THEN RETURN 31;
                END CASE;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `gdate`(`jy` smallint, `jm` smallint, `jd` smallint) RETURNS datetime
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i, j, e, k, mo,
                    gy, gm, gd,
                    g_day_no, j_day_no, bkab, jmm, mday, g_day_mo, bkab1, j1
                INT DEFAULT 0;
                DECLARE fdate datetime;

                SET bkab = __mymod(jy,33);

                IF (bkab = 1 or bkab= 5 or bkab = 9 or bkab = 13 or bkab = 17 or bkab = 22 or bkab = 26 or bkab = 30) THEN
                    SET j=1;
                end IF;

                SET bkab1 = __mymod(jy+1,33);

                IF (bkab1 = 1 or bkab1= 5 or bkab1 = 9 or bkab1 = 13 or bkab1 = 17 or bkab1 = 22 or bkab1 = 26 or bkab1 = 30) THEN
                    SET j1=1;
                end IF;

                CASE jm
                    WHEN 1 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 2 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 3 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 4 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 5 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 6 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 7 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 8 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 9 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 10 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 11 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 12 THEN IF jd > _jdmarray2(jm)+j or jd <= 0 THEN SET e=1; end IF;
                END CASE;
                IF jm > 12 or jm <= 0 THEN SET e=1; end IF;
                IF jy <= 0 THEN SET e=1; end IF;

                IF e>0 THEN
                    RETURN 0;
                end IF;

                IF (jm>=11) or (jm=10 and jd>=11 and j=0) or (jm=10 and jd>11 and j=1) THEN
                    SET i=1;
                end IF;
                SET gy = jy + 621 + i;

                IF (__mymod(gy,4)=0) THEN
                    SET k=1;
                end IF;

                IF (__mymod(gy,100)=0) and (__mymod(gy,400)<>0) THEN
                    SET k=0;
                END IF;

                SET jmm=jm-1;

                WHILE (jmm > 0) do
                    SET mday=mday+_jdmarray2(jmm);
                    SET jmm=jmm-1;
                end WHILE;

                SET j_day_no=(jy-1)*365+(__mydiv(jy,4))+mday+jd;
                SET g_day_no=j_day_no+226899;

                SET g_day_no=g_day_no-(__mydiv(gy-1,4));
                SET g_day_mo=__mymod(g_day_no,365);

                IF (k=1 and j=1) THEN
                    IF (g_day_mo=0) THEN
                        RETURN CONCAT_WS(\'-\',gy,\'12\',\'30\');
                    END IF;
                    IF (g_day_mo=1) THEN
                        RETURN CONCAT_WS(\'-\',gy,\'12\',\'31\');
                    END IF;
                END IF;

                IF (g_day_mo=0) THEN
                    RETURN CONCAT_WS(\'-\',gy,\'12\',\'31\');
                END IF;

                SET mo=0;
                SET gm=gm+1;
                while g_day_mo>_gdmarray2(mo,k) do
                    SET g_day_mo=g_day_mo-_gdmarray2(mo,k);
                    SET mo=mo+1;
                    SET gm=gm+1;
                end WHILE;
                SET gd=g_day_mo;

                RETURN CONCAT_WS(\'-\',gy,gm,gd);
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION `gdatestr`(`jdat` char(10)) RETURNS datetime
            READS SQL DATA
            DETERMINISTIC
            BEGIN
                DECLARE
                    i, j, e, k, mo,
                    gy, gm, gd,
                    g_day_no, j_day_no, bkab, jmm, mday, g_day_mo, jd, jy, jm,bkab1,j1
                INT DEFAULT 0;
                DECLARE jdd, jyd, jmd, jt varchar(100);
                DECLARE fdate datetime;

                SET jdd = SUBSTRING_INDEX(jdat, \'/\', -1);
                SET jt = SUBSTRING_INDEX(jdat, \'/\', 2);
                SET jyd = SUBSTRING_INDEX(jt, \'/\', 1);
                SET jmd = SUBSTRING_INDEX(jt, \'/\', -1);
                SET jd = CAST(jdd as SIGNED);
                SET jy = CAST(jyd as SIGNED);
                SET jm = CAST(jmd as SIGNED);

                SET bkab = __mymod(jy,33);

                IF (bkab = 1 or bkab= 5 or bkab = 9 or bkab = 13 or bkab = 17 or bkab = 22 or bkab = 26 or bkab = 30) THEN
                    SET j=1;
                end IF;

                SET bkab1 = __mymod(jy+1,33);

                IF (bkab1 = 1 or bkab1= 5 or bkab1 = 9 or bkab1 = 13 or bkab1 = 17 or bkab1 = 22 or bkab1 = 26 or bkab1 = 30) THEN
                    SET j1=1;
                end IF;

                CASE jm
                    WHEN 1 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 2 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 3 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 4 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 5 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 6 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 7 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 8 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 9 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 10 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 11 THEN IF jd > _jdmarray2(jm) or jd <= 0 THEN SET e=1; end IF;
                    WHEN 12 THEN IF jd > _jdmarray2(jm)+j or jd <= 0 THEN SET e=1; end IF;
                END CASE;
                IF jm > 12 or jm <= 0 THEN SET e=1; end IF;
                IF jy <= 0 THEN SET e=1; end IF;

                IF e>0 THEN
                    RETURN 0;
                end IF;

                IF (jm>=11) or (jm=10 and jd>=11 and j=0) or (jm=10 and jd>11 and j=1) THEN
                    SET i=1;
                end IF;
                SET gy = jy + 621 + i;

                IF (__mymod(gy,4)=0) THEN
                    SET k=1;
                end IF;

                IF (__mymod(gy,100)=0) and (__mymod(gy,400)<>0) THEN
                    SET k=0;
                END IF;

                SET jmm=jm-1;

                WHILE (jmm > 0) do
                    SET mday=mday+_jdmarray2(jmm);
                    SET jmm=jmm-1;
                end WHILE;

                SET j_day_no=(jy-1)*365+(__mydiv(jy,4))+mday+jd;
                SET g_day_no=j_day_no+226899;

                SET g_day_no=g_day_no-(__mydiv(gy-1,4));
                SET g_day_mo=__mymod(g_day_no,365);

                IF (k=1 and j=1) THEN
                    IF (g_day_mo=0) THEN
                        RETURN CONCAT_WS(\'-\',gy,\'12\',\'30\');
                    END IF;
                    IF (g_day_mo=1) THEN
                        RETURN CONCAT_WS(\'-\',gy,\'12\',\'31\');
                    END IF;
                END IF;

                IF (g_day_mo=0) THEN
                    RETURN CONCAT_WS(\'-\',gy,\'12\',\'31\');
                END IF;

                SET mo=0;
                SET gm=gm+1;
                while g_day_mo>_gdmarray2(mo,k) do
                    SET g_day_mo=g_day_mo-_gdmarray2(mo,k);
                    SET mo=mo+1;
                    SET gm=gm+1;
                end WHILE;
                SET gd=g_day_mo;

                RETURN CONCAT_WS(\'-\',gy,gm,gd);
            END;
        ');


    }


    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS `__mydiv`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `__mymod`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `_gdmarray`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `_jdmarray`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `_jdmarray2`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `pdate`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `PMONTH`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `pmonthname`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `pyear`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `pday`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `_gdmarray2`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `gdate`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `gdatestr`;');

    }
};