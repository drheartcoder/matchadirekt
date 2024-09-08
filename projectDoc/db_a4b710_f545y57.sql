-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql6001.site4now.net
-- Generation Time: Sep 06, 2019 at 05:02 AM
-- Server version: 5.6.26-log
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_a4b710_f545y57`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_active_opened_jobs` ()  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.sts='active' AND CURRENT_DATE < pj.last_date;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_active_opened_jobs_by_company_id` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.company_ID=comp_id AND pj.sts='active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_active_records_by_city_front_end` (IN `city` VARCHAR(40))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.city=city AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_active_records_by_industry_front_end` (IN `industry_id` INT(11))  BEGIN
	SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.industry_ID=industry_id AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_applied_jobs_by_employer_id` (IN `employer_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_post_jobs.employer_ID=employer_id;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id
    and tbl_seeker_applied_for_job.deleted=0
    ;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255))  BEGIN
	SELECT COUNT(pj.ID) as total
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_ft_search_job` (IN `param` VARCHAR(255), `param2` VARCHAR(255))  BEGIN
	SELECT COUNT(pc.ID) as total
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = 'active' AND pc.sts = 'active'
AND (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pj.city like CONCAT("%",param2,"%");
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_ft_search_resume` (IN `param` VARCHAR(255))  BEGIN
	SELECT COUNT(DISTINCT ss.ID) as total
	FROM `tbl_job_seekers` js 
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' 
AND ss.skill_name like CONCAT('%',param,'%');
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `count_search_posted_jobs` (IN `where_condition` VARCHAR(255))  BEGIN
	SET @query = "SELECT COUNT(pj.ID) as total
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE
";

SET @where_clause = CONCAT(where_condition);
SET @query = CONCAT(@query, @where_clause);

PREPARE stmt FROM @query;
EXECUTE stmt;

END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, MATCH(pj.job_title, pj.job_description) AGAINST( param_title ) AS score
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param_title,"%") OR pj.job_description like CONCAT("%",param_title,"%") OR pj.required_skills like CONCAT("%",param_title,"%")) 
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'

ORDER BY score DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_job` (IN `param` VARCHAR(255), IN `param2` VARCHAR(255), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN

	SELECT pj.ID,pj.required_skills, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, MATCH(pj.job_title, pj.job_description) AGAINST(param) AS score
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = 'active' AND pc.sts = 'active' 
	AND (
			pj.job_title like CONCAT("%",param,"%") 
			OR pj.job_description like CONCAT("%",param,"%") 
			OR pj.required_skills like CONCAT("%",param,"%") 
			OR pj.pay like CONCAT("%",REPLACE(param,' ','-'),"%")
			OR pj.city like CONCAT("%",param,"%")
		)
		AND (pj.city) like CONCAT("%",param2,"%")
ORDER BY pj.ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_jobs_group_by_city` (IN `param` VARCHAR(255))  BEGIN
	SELECT city, COUNT(city) as score
	FROM `tbl_post_jobs` pj 
	WHERE pj.sts = 'active' 
AND (
			pj.job_title like CONCAT("%",param,"%") 
			OR pj.job_description like CONCAT("%",param,"%") 
			OR pj.required_skills like CONCAT("%",param,"%") 
			OR pj.pay like CONCAT("%",REPLACE(param,' ','-'),"%")
			OR pj.city like CONCAT("%",param,"%")
		)
	GROUP BY city
	ORDER BY score DESC
	LIMIT 0,5;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_jobs_group_by_company` (IN `param` VARCHAR(255))  BEGIN
	SELECT  pc.company_name,pc.company_slug, COUNT(pc.company_name) as score
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = 'active' AND pc.sts = 'active' 
AND (
			pj.job_title like CONCAT("%",param,"%") 
			OR pj.job_description like CONCAT("%",param,"%") 
			OR pj.required_skills like CONCAT("%",param,"%") 
			OR pj.pay like CONCAT("%",REPLACE(param,' ','-'),"%")
			OR pj.city like CONCAT("%",param,"%")
		)
	GROUP BY pc.company_name
	ORDER BY score DESC
	LIMIT 0,5;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_jobs_group_by_salary_range` (IN `param` VARCHAR(255))  BEGIN
	SELECT pay, COUNT(pay) as score
	FROM `tbl_post_jobs` pj 
	WHERE pj.sts = 'active' 
AND (
			pj.job_title like CONCAT("%",param,"%") 
			OR pj.job_description like CONCAT("%",param,"%") 
			OR pj.required_skills like CONCAT("%",param,"%") 
			OR pj.pay like CONCAT("%",REPLACE(param,' ','-'),"%")
			OR pj.city like CONCAT("%",param,"%")
		)
	GROUP BY pay
	ORDER BY score DESC
	LIMIT 0,5;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_jobs_group_by_title` (IN `param` VARCHAR(255))  BEGIN
	SELECT job_title, COUNT(job_title) as score
	FROM `tbl_post_jobs` pj 
	WHERE pj.sts = 'active' 
AND (
			pj.job_title like CONCAT("%",param,"%") 
			OR pj.job_description like CONCAT("%",param,"%") 
			OR pj.required_skills like CONCAT("%",param,"%") 
			OR pj.pay like CONCAT("%",REPLACE(param,' ','-'),"%")
			OR pj.city like CONCAT("%",param,"%")
		)

	GROUP BY job_title
	ORDER BY score DESC
	LIMIT 0,5;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `ft_search_resume` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
  SELECT js.ID, js.first_name, js.gender, js.dob, js.city, js.photo
	FROM tbl_job_seekers AS js
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' AND ss.skill_name like CONCAT("%",param,"%")
  GROUP BY ss.seeker_ID
	ORDER BY js.ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_active_deactive_posted_job_by_company_id` (IN `comp_id` INT(11), IN `from_limit` INT(4), IN `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts IN ('active', 'inactive', 'pending', 'archive') AND pc.sts = 'active' AND pc.sts <> 'archive'
    and pj.deleted=0 
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_active_featured_job` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes' AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_active_posted_job_by_company_id` (IN `comp_id` INT(11), IN `from_limit` INT(4), IN `to_limit` INT(4))  BEGIN
		SELECT pj.diarie,pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_active_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, emp.first_name, emp.email AS employer_email, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,emp.city as emp_city, emp.country as emp_country	
FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON pc.ID=emp.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND pc.sts = 'active'  AND tbl_post_jobs.deleted =0;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_active_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_active_top_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active' AND emp.top_employer = 'yes'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_opened_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, ji.industry_name 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.sts = 'active' AND pc.sts='active'
	ORDER BY pj.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_posted_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, pj.ip_address 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_all_posted_jobs_by_status` (IN `job_status` VARCHAR(10), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = job_status
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_applied_jobs_by_employer_id` (IN `employer_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.*,tbl_seeker_applied_for_job.ID, tbl_seeker_applied_for_job.flag,tbl_seeker_applied_for_job.dated AS applied_date,tbl_seeker_applied_for_job.seeker_ID,tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.skills_level, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.job_title, tbl_job_seekers.ID AS job_seeker_ID, tbl_post_jobs.job_slug, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.slug
	FROM `tbl_seeker_applied_for_job`
	left JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_seeker_applied_for_job.employer_ID=employer_id 
    AND (tbl_post_jobs.sts<>'archive' or tbl_post_jobs.sts is null )
    and tbl_seeker_applied_for_job.deleted=0 
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.ID as applied_id,tbl_seeker_applied_for_job.flag, tbl_seeker_applied_for_job.dated AS applied_date, tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.skills_level, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_companies.company_name, tbl_companies.company_slug, tbl_companies.company_logo 
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_employers ON tbl_employers.ID=tbl_post_jobs.employer_ID
	INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_ID
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id 
    AND tbl_post_jobs.sts<>'archive'
    and tbl_seeker_applied_for_job.deleted=0
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_applied_jobs_by_seeker_id` (IN `applicant_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
		SELECT aj.*, tbl_post_jobs.ID AS posted_job_id, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.flag,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.employer_ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_companies.company_name, tbl_companies.company_logo, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.photo
	FROM `tbl_seeker_applied_for_job` aj
	INNER JOIN tbl_job_seekers ON aj.seeker_ID=tbl_job_seekers.ID
	INNER JOIN tbl_post_jobs ON aj.job_ID=tbl_post_jobs.ID
	INNER JOIN tbl_companies ON tbl_post_jobs.company_ID=tbl_companies.ID
	WHERE aj.seeker_ID=applicant_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_company_by_slug` (IN `slug` VARCHAR(70))  BEGIN
	SELECT emp.ID AS empID, pc.ID, emp.country, emp.city, pc.company_name, pc.company_description, pc.company_location, pc.company_website, pc.no_of_employees, pc.established_in, pc.company_logo, pc.company_slug
	FROM `tbl_employers` AS emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE pc.company_slug=slug AND emp.sts='active';
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_experience_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_experience.* 
	FROM `tbl_seeker_experience`
	WHERE tbl_seeker_experience.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_experience.start_date DESC;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_featured_job` (IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes' AND pj.sts<>'archive'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_latest_posted_job_by_employer_ID` (IN `emp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_opened_jobs_home_page` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
set @prev := 0, @rownum := '';
SELECT ID, job_title, job_slug, employer_ID, company_ID, job_description, city, dated, last_date, is_featured, sts, company_name, company_logo, company_slug, industry_name 
FROM (
  SELECT ID, job_title, job_slug, employer_ID, company_ID, job_description, city, dated, last_date, is_featured, sts, company_name, company_logo, company_slug, industry_name, 
         IF( @prev <> company_ID, 
             @rownum := 1, 
             @rownum := @rownum+1 
         ) AS rank, @prev := company_ID, 
         @rownum  
			FROM (
					SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, company_name, company_logo, company_slug, industry_name 
					FROM tbl_post_jobs AS pj
					INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
					INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID	
					WHERE pj.sts = 'active' AND pc.sts='active'
					ORDER BY company_ID DESC, ID DESC
			) pj
) jobs_ranked 
WHERE jobs_ranked.rank <= 2
ORDER BY jobs_ranked.ID DESC 
LIMIT from_limit,to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_posted_job_by_company_id` (IN `comp_id` INT(11), IN `from_limit` INT(4), IN `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.job_description, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.company_ID=comp_id AND tbl_post_jobs.deleted =0
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_posted_job_by_employer_id` (IN `emp_id` INT(11), IN `from_limit` INT(4), IN `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.job_description, tbl_post_jobs.contact_person, tbl_post_jobs.contact_email, tbl_post_jobs.contact_phone, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id  AND tbl_post_jobs.deleted =0
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
		SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,em.city as emp_city, em.country as emp_country
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
  INNER JOIN tbl_employers AS em ON pc.ID=em.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_posted_job_by_id_employer_id` (IN `job_id` INT(11), IN `emp_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND tbl_post_jobs.employer_ID=emp_id  AND tbl_post_jobs.deleted =0;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `get_qualification_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_academic.* 
	FROM `tbl_seeker_academic`
	WHERE tbl_seeker_academic.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_academic.completion_year DESC;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `job_search_by_city` (IN `param_city` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `job_search_by_industry` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.industry_ID = param AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`a4b710_f545y57`@`%` PROCEDURE `search_posted_jobs` (IN `where_condition` VARCHAR(255), `from_limit` INT(11), `to_limit` INT(11))  BEGIN
	SET @query = "SELECT pj.ID, pj.job_title,  pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE
";

SET @where_clause = CONCAT(where_condition);
SET @after_where_clause = CONCAT("ORDER BY ID DESC LIMIT ",from_limit,", ",to_limit,"");
SET @full_search_clause = CONCAT(@where_clause, @after_where_clause);
SET @query = CONCAT(@query, @full_search_clause);

PREPARE stmt FROM @query;
EXECUTE stmt;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id_calendar`, `id_employer`, `id_job_seeker`, `notes`, `date`) VALUES
(3, 1, 10, 'Interview with Jhony Man', '2018-01-26 10:00:00'),
(4, 1, 10, 'aasasa', '2018-01-26 12:00:00'),
(5, 209, 423, 'Interview with Ram', '2018-02-27 10:00:00'),
(6, 209, 426, 'Interview with Ramtaniii', '2018-01-28 10:00:00'),
(7, 209, 423, 'Interview with Ram', '0000-00-00 00:00:00'),
(8, 209, 10, 'Interview with Jhony Man', '2018-01-30 11:00:00'),
(9, 215, 429, 'Interview with Johan Gustafsson', '2018-01-28 03:00:00'),
(10, 213, 430, 'Interview with William Schwarz', '2018-01-29 10:00:00'),
(11, 211, 428, 'Interview with Fredrik %C3%96hrn', '2018-01-31 09:15:00'),
(12, 210, 427, 'Interview with Tim S', '2018-01-29 11:00:00'),
(13, 1, 10, 'Interview with Jhony Man', '2018-01-30 10:00:00'),
(14, 1, 10, 'Interview with Jhony Man', '2018-01-30 10:00:00'),
(15, 211, 428, 'Interview with Fredrik %C3%96hrn', '2018-02-08 01:00:00'),
(16, 211, 423, 'Interview with Ram', '2018-02-05 02:15:00'),
(17, 215, 430, 'Intervju med William Schwarz', '2018-02-05 01:00:00'),
(18, 215, 430, 'Intervju med William Schwarz', '2018-02-05 08:00:00'),
(19, 215, 430, 'Interview with William Schwarz', '2018-02-05 08:00:00'),
(20, 215, 430, 'Intervju med William Schwarz', '2018-02-05 10:00:00'),
(21, 215, 427, 'Intervju med Tim S', '2018-02-06 10:00:00'),
(29, 209, 449, 'Interview with random', '2018-02-05 10:00:00'),
(31, 211, 448, 'Interview with MOUHCIN AGOUJIL', '2018-01-30 10:00:00'),
(32, 211, 430, 'Interview with William Schwarz', '2018-01-30 10:00:00'),
(33, 211, 448, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(34, 211, 430, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(35, 211, 430, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(36, 211, 430, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(37, 211, 430, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(38, 211, 430, 'Interview with MOUHCIN AGOUJIL', '2018-01-31 16:00:00'),
(39, 210, 424, 'Meeting for interview', '2018-02-02 10:00:00'),
(40, 209, 10, 'Interview with Jhony Man', '2018-01-30 11:00:00'),
(41, 209, 448, 'Interview with MOUHCIN AGOUJIL', '2018-02-18 10:00:00'),
(42, 209, 448, 'Interview to work', '2018-02-18 10:00:00'),
(43, 209, 448, 'Interview to work', '2018-02-28 10:00:00'),
(44, 210, 424, 'Meeting for interview', '2018-02-28 10:00:00'),
(46, 221, 462, 'Interview with Frida Vastam%C3%A4ki', '2018-07-14 10:00:00'),
(53, 221, 462, 'Interview with Frida', '2018-06-14 13:30:00'),
(54, 221, 462, 'Frida vastam%C3%A4ki', '2018-06-14 13:30:00'),
(55, 221, 462, 'Frida vastam_C3_A4ki', '2018-06-14 13:30:00'),
(56, 221, 462, 'Frida Vastam%C3%A4ki', '2018-09-05 13:30:00'),
(57, 221, 462, 'D%C3%A4r h%C3%A5r %C3%B6r', '2018-09-13 13:30:00'),
(58, 221, 462, 'd%C3%A4 m%C3%A4', '2018-09-13 13:30:00'),
(59, 221, 467, 'Interview with Testsep  %C3%A5%C3%A4%C3%B6', '2018-09-11 10:00:00'),
(60, 209, 467, 'Interview with Testsep %C3%84%C3%96%C3%85', '2018-09-11 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(8) NOT NULL,
  `admin_username` varchar(80) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_username`, `admin_password`, `type`) VALUES
(1, 'admin', '$2y$10$S4.g5gSgs.OtyWumGpyPYeLun8pMZZSnHrDiFOSs3vPrVQ.gmN9Za', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ad_codes`
--

CREATE TABLE `tbl_ad_codes` (
  `ID` int(4) NOT NULL,
  `bottom` text,
  `right_side_1` text,
  `right_side_2` text,
  `google_analytics` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ad_codes`
--

INSERT INTO `tbl_ad_codes` (`ID`, `bottom`, `right_side_1`, `right_side_2`, `google_analytics`) VALUES
(1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_channels`
--

CREATE TABLE `tbl_channels` (
  `ID` int(11) NOT NULL,
  `channel` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_channels`
--

INSERT INTO `tbl_channels` (`ID`, `channel`) VALUES
(1, 'Channel 1'),
(3, 'Channel 2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cities`
--

CREATE TABLE `tbl_cities` (
  `ID` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `city_slug` varchar(150) NOT NULL,
  `city_name` varchar(150) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '998',
  `country_ID` int(11) NOT NULL,
  `is_popular` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cities`
--

INSERT INTO `tbl_cities` (`ID`, `show`, `city_slug`, `city_name`, `sort_order`, `country_ID`, `is_popular`) VALUES
(14, 1, '', 'Stockholm', 998, 0, 'yes'),
(25, 1, '', 'Malmö', 998, 0, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms`
--

CREATE TABLE `tbl_cms` (
  `pageID` int(11) NOT NULL,
  `pageTitle` varchar(100) DEFAULT NULL,
  `pageSlug` varchar(100) DEFAULT NULL,
  `pageContent` text,
  `pageImage` varchar(100) DEFAULT NULL,
  `pageParentPageID` int(11) DEFAULT '0',
  `dated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `pageStatus` enum('Inactive','Published') DEFAULT 'Inactive',
  `seoMetaTitle` varchar(100) DEFAULT NULL,
  `seoMetaKeyword` varchar(255) DEFAULT NULL,
  `seoMetaDescription` varchar(255) DEFAULT NULL,
  `seoAllowCrawler` tinyint(1) DEFAULT '1',
  `pageCss` text,
  `pageScript` text,
  `menuTop` tinyint(4) DEFAULT '0',
  `menuBottom` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cms`
--

INSERT INTO `tbl_cms` (`pageID`, `pageTitle`, `pageSlug`, `pageContent`, `pageImage`, `pageParentPageID`, `dated`, `pageStatus`, `seoMetaTitle`, `seoMetaKeyword`, `seoMetaDescription`, `seoAllowCrawler`, `pageCss`, `pageScript`, `menuTop`, `menuBottom`) VALUES
(7, 'About Us', 'about-us.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nSuspendisse quis mi commodo, eleifend massa ut, dapibus ligula.<br />\nMaecenas sagittis sem sed sapien blandit venenatis.<br />\nPraesent eleifend ligula id ex condimentum, eu finibus lorem hendrerit.<br />\nVestibulum consequat nunc a elit faucibus lacinia.<br />\nProin quis libero eget lorem vulputate imperdiet.<br />\nVivamus iaculis arcu eget libero imperdiet, sit amet posuere ante consectetur.', 'about-company1.jpg', 0, '2016-11-27 09:33:43', 'Published', 'About Us', 'About Job Portal, Jobs, IT', 'The leading online job portal', 1, NULL, NULL, 1, 1),
(13, 'How To Get Job', 'how-to-get-job.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', NULL, 0, '2017-08-27 18:50:08', 'Published', 'How To Get Job', 'Tips, Job, Online', 'How to get job includes tips and tricks to crack interview', 1, NULL, NULL, 0, 0),
(14, 'Interview', 'interview.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', NULL, 0, '2016-11-27 09:42:22', 'Published', 'Interview', 'job, jobs, interview, tips', 'How to take interview', 1, NULL, NULL, 0, 0),
(15, 'ATT SKRIVA CV', 'cv-writing.html', 'Ett bra och tydligt CV g&ouml;r det m&ouml;jligt f&ouml;r rekryteraren att f&ouml;rst&aring; varf&ouml;r just du &auml;r r&auml;tt f&ouml;r jobbet du vill ha. Att skriva CV p&aring; ett strukturerat s&auml;tt visar dina erfarenheter och kunskaper medan du i ditt personliga brev kan ber&auml;tta mer om vem du &auml;r och varf&ouml;r du passar f&ouml;r tj&auml;nsten du s&ouml;ker. Men vilken information ska egentligen finnas med i ditt CV? Hur l&aring;ngt ska det vara? Och hur strukturerar du det s&aring; det blir l&auml;tt att l&auml;sa? H&auml;r nedanf&ouml;r f&aring;r du bra hj&auml;lp.<br />\r\n<br />\r\n<strong>CV - OLIKA FORMAT</strong><br />\r\nN&auml;r du s&ouml;ker jobb genom oss s&aring; kan du anv&auml;nda ett eget CV som bifogad fil. Eller s&aring; anv&auml;nder du det CV som automatiskt skapas n&auml;r du registrerar ett konto hos oss. Ett tips &auml;r att ocks&aring; g&ouml;ra ditt CV s&ouml;kbart genom fylla i dina uppgifter, erfarenheter och kunskaper direkt under ditt konto.&nbsp;H&auml;r kan du ladda ned en enkel CV-mall&nbsp;som du kan anv&auml;nda som st&ouml;d n&auml;r du skriver ditt eget CV.<br />\r\n<br />\r\n<strong>L&Auml;TT&Ouml;VERSK&Aring;DLIGT CV</strong><br />\r\nEtt grundl&auml;ggande tips &auml;r att ditt CV ska vara l&auml;tt&ouml;versk&aring;dligt och snabbt ge en bild av dig och dina kvalifikationer. Dela upp ditt CV i tydliga rubriker som arbetslivserfarenhet och utbildning och se till att allt &auml;r uppst&auml;llt i kronologisk ordning med dina senaste erfarenheter f&ouml;rst. L&auml;ngden p&aring; ditt CV &auml;r inte avg&ouml;rande s&aring; l&auml;nge strukturen k&auml;nns logisk och informationen &auml;r l&auml;tt att f&ouml;lja. T&auml;nk p&aring; att ditt CV inte ska beskriva dig som person, utan visa p&aring; dina erfarenheter och kunskap.<br />\r\n<br />\r\n<strong>KONTAKTUPPGIFTER</strong><br />\r\nL&auml;gg dina kontaktuppgifter d&auml;r de syns tydligt, h&ouml;gst upp i ditt CV brukar vara en bra plats. De uppgifter som &auml;r bra att ha med &auml;r namn och ett s&auml;tt f&ouml;r oss att n&aring; dig, till exempel telefonnummer eller mailadress.&nbsp;&nbsp;<br />\r\n<br />\r\n<strong>ARBETSLIVSERFARENHET</strong><br />\r\nVilka tidigare tj&auml;nster du skriver med i ditt CV beror p&aring; hur l&aring;ngt i karri&auml;ren du kommit. Om du inte har jobbat s&aring; l&auml;nge, kan all arbetslivserfarenhet vara bra att ta med. Har du d&auml;remot hunnit f&aring; n&aring;gra &aring;rs arbetslivserfarenhet beh&ouml;ver du inte n&auml;mna alla jobb du haft. Plocka med dem som k&auml;nns mest relevanta f&ouml;r den tj&auml;nst du s&ouml;ker. Komplettera f&ouml;retagets namn, tj&auml;nstens titel och perioden du arbetade med en kort beskrivning om vad jobbet innebar. Vad l&auml;rde du dig, vad ansvarade du f&ouml;r och hur s&aring;g dina resultat ut? Den beskrivande delen &auml;r viktig f&ouml;r att rekryteraren ska kunna skaffa sig en uppfattning av hur dina tidigare erfarenheter kan vara aktuella f&ouml;r den tj&auml;nsten du s&ouml;ker. Skriv om din nuvarande eller senaste arbetsgivare &ouml;verst och fyll p&aring; med de andra under.<br />\r\n<br />\r\n<strong>UTBILDNING</strong><br />\r\nH&auml;r g&auml;ller samma regel som f&ouml;r delen om arbetslivserfarenhet, plocka med det som k&auml;nns mest relevant f&ouml;r tj&auml;nsten du s&ouml;ker. B&ouml;rja med att presentera det du studerade senast och g&aring; sedan bak&aring;t i tiden. Om du har en l&auml;ngre utbildning beh&ouml;ver du inte ta med alla delar av dina studier - har du exempelvis en magisterexamen beh&ouml;ver du inte i ditt CV ber&auml;tta var du g&aring;tt i grundskolan &ndash; det viktiga &auml;r att se var du befinner dig idag och dina senaste steg innan dess. &nbsp; Ange skolans namn, vilken ort den finns p&aring;, vilket program eller kurs du l&auml;st och under vilken tidsperiod du studerade. Om du studerar idag s&aring; skriv att din utbildning &auml;r p&aring;g&aring;ende och n&auml;mn vilken examen du planerar att ta.<br />\r\n<br />\r\n<strong>&Ouml;VRIGA MERITER</strong><br />\r\nBeskriv kortfattat dina uppdrag i f&ouml;reningar, k&aring;rer, organisationer eller annat ideellt engagemang. Ber&auml;tta &auml;ven h&auml;r hur dina ansvarsomr&aring;den s&aring;g ut s&aring; att rekryteraren kan f&ouml;rst&aring; varf&ouml;r erfarenheterna du tagit upp i ditt CV kan vara relevanta f&ouml;r tj&auml;nsten du s&ouml;ker.<br />\r\n<br />\r\n<strong>SPR&Aring;KKUNSKAPER</strong><br />\r\nSkriv de spr&aring;k du beh&auml;rskar och gl&ouml;m inte att gradera din kunskap. Ett vanligt s&auml;tt att gradera spr&aring;kkunskaper p&aring; &auml;r; grundl&auml;ggande, goda, mycket goda och flytande. B&ouml;rja med att presentera de spr&aring;k du kan flytande och forts&auml;tt sedan ned&aring;t.<br />\r\n<br />\r\n<strong>&Ouml;VRIGA KOMPETENSER</strong><br />\r\nN&auml;mn de system, program, programmeringsspr&aring;k eller tekniker du beh&auml;rskar. Gl&ouml;m inte att &auml;ven gradera dina kunskaper. Skriv f&ouml;rst de kompetenser du beh&auml;rskar b&auml;st f&ouml;r att ge en tydlig &ouml;verblick. H&auml;r kan du &auml;ven skriva med innehav av k&ouml;rkort om det efterfr&aring;gas i tj&auml;nsten.<br />\r\n<br />\r\n<strong>REFERENSER</strong><br />\r\nI regel r&auml;cker det att du i ditt CV skriver &rdquo;referenser l&auml;mnas g&auml;rna p&aring; beg&auml;ran&rdquo;. T&auml;nk igenom vilka personer som kan beskriva dig och dina f&auml;rdigheter p&aring; ett bra s&auml;tt. Det kan exempelvis vara tidigare chefer, kollegor eller handledaren fr&aring;n utbildningen. St&auml;m alltid av med de personer du l&auml;mnar som referenser s&aring; att de &auml;r f&ouml;rberedda p&aring; att bli kontaktade av rekryteraren. L&auml;s fler referenstips fr&aring;n rekryterare p&aring; v&aring;r blogg.<br />\r\n<br />\r\n<strong>LAYOUT</strong><br />\r\nDet allra viktigaste &auml;r att ditt CV &auml;r l&auml;tt&ouml;versk&aring;dligt och enkelt f&ouml;r rekryteraren att f&ouml;rst&aring;. S&aring; l&auml;gg lagom med tid och engagemang p&aring; det grafiska utseendet. Satsa ist&auml;llet p&aring; att l&auml;sa igenom ditt CV en extra g&aring;ng f&ouml;r att undvika on&ouml;diga stavfel!<br />\r\n<br />\r\n<strong>SKRIV ETT PERSONLIGT BREV</strong><br />\r\nDitt personliga brev &auml;r ett bra komplement till ditt CV och det ger dig m&ouml;jlighet att tydligare beskriva dig som person, dina styrkor, m&aring;l och ambitioner. Det &auml;r framf&ouml;rallt h&auml;r du ska motivera varf&ouml;r du s&ouml;ker den utannonserade tj&auml;nsten.&nbsp;<br />\r\n<br />\r\nSource:&nbsp;https://www.academicwork.se/att-skriva-cv', NULL, 0, '2018-01-25 18:14:45', 'Published', 'CV writing tips and tricks', 'CV, resume', 'How to write a professional CV.', 1, NULL, NULL, NULL, NULL),
(16, 'Privacy Policy', 'privacy-policy.html', '<p>&sect; 1Matchadirekt</p>\r\n\r\n<p>Matchadirekt &auml;r ett kontaktn&auml;tverk mellan dig och arbetsgivare som ger dig m&ouml;jlighet att skicka in jobbans&ouml;kan och spontanans&ouml;kan samt att &auml;ven skicka meddelanden direkt till personalavdelningen.</p>\r\n\r\n<p>&sect; 2 Anv&auml;ndning av tj&auml;nsten</p>\r\n\r\n<p>Att s&ouml;ka jobb hos en arbetsgivare genom rekryteringssystemet Matchadirekt &auml;r helt kostnadsfritt.</p>\r\n\r\n<p>&sect; 3 Dataskyddsf&ouml;rordningen (GDPR) och &ouml;vrig information</p>\r\n\r\n<p>Genom att godk&auml;nna dessa villkor till&aring;ter du att dina uppgifter lagras enligt <a href=\"https://www.datainspektionen.se/dataskyddsreformen/\" target=\"_blank\">Dataskyddsf&ouml;rordningen (GDPR)</a>. Om du s&ouml;ker ett jobb hos en offentlig arbetsgivare g&auml;ller &auml;ven <a href=\"http://www.regeringen.se/sa-styrs-sverige/det-demokratiska-systemet-i-sverige/offentlighetsprincipen/\" target=\"_blank\">Offentlighetsprincipen</a>. Alla villkor skrivna h&auml;r kan &ouml;ver tiden komma att &auml;ndras. Om och n&auml;r det sker kommer du att informeras via mail.</p>\r\n\r\n<p>Det &auml;r inte till&aring;tet att anv&auml;nda Matchadirekts logotype, namn eller annat m&auml;rke i n&aring;gra sammanhang utan att Matchadirekt skriftligen har godk&auml;nt detta. S&ouml;ker du kontakt med Matchadirekt anv&auml;nd kontaktformul&auml;ret p&aring; webbsidan eller anv&auml;nd f&ouml;ljande adresser:<br />\r\n&nbsp;</p>\r\n\r\n<p>DigitalMcenter AB</p>\r\n\r\n<p>Finlandsgatan 52</p>\r\n\r\n<p>164 74 Kista.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&sect; 4 Rekrytering</p>\r\n\r\n<p>Alla dialoger med arbetsgivare som leder fram till jobberbjudande &auml;r en sak mellan arbetsgivare och arbetstagare. Matchadirekt har inget ansvar f&ouml;r eventuella avtal som skrivs eller undertecknas i Matchadirekt.</p>\r\n\r\n<p>&sect; 5 Missf&ouml;rst&aring;nd</p>\r\n\r\n<p>Matchadirekt &auml;r inte ansvarig f&ouml;r eventuella missf&ouml;rst&aring;nd, felaktig information eller andra orsaker som kan leda till att avtal, &ouml;verenskommelse eller dialog blir feltolkad.</p>\r\n\r\n<p>&sect; 6 Information om cookies</p>\r\n\r\n<p>En cookie &auml;r en liten textfil som t.ex. kan inneh&aring;lla inst&auml;llningar, gjorda val och/eller anv&auml;ndarinformation. Den sparas ner p&aring; din dator d&aring; du bes&ouml;ker webbplatsen. Du kan sj&auml;lv g&ouml;ra inst&auml;llningar i din webbl&auml;sare om du vill till&aring;ta cookies eller inte.</p>\r\n\r\n<p>&sect; 7 Dina uppgifter</p>\r\n\r\n<p>Dina personliga uppgifter som lagras i Matchadirekt s&aring; som namn, foto, bild, adress, email, telefonnummer, nuvarande och tidigare arbetsgivare kommer att h&aring;llas dolda f&ouml;r arbetsgivare. Dina uppgifter kommer endast att synligg&ouml;ras f&ouml;r en arbetsgivare efter att du sj&auml;lv har gett dem till&aring;telse att se dina uppgifter. Om du &ouml;nskar att avsluta ditt konto s&auml;nder du ett mail till support@matchadirekt.com med rubriken Avsluta.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&sect; 8 Nyhetsmail</p>\r\n\r\n<p>Mail med tj&auml;nster som passar din profil kan komma att skickas till dig. &Ouml;nskar en arbetsgivare komma i kontakt med dig skickas ett mail till dig fr&aring;n Matchadirekt.</p>\r\n\r\n<p>&sect; 9 Drift</p>\r\n\r\n<p>Matchadirekt garanterar ingen drifts&auml;kerhet och ger inga ers&auml;ttningar f&ouml;r f&ouml;rlorad information oavsett orsak.</p>\r\n\r\n<p>&sect; 10 &Aring;taganden</p>\r\n\r\n<p>P&aring; Matchadirekt g&auml;ller svenska lagar. Matchadirekt till&aring;ter ingen illegal verksamhet. Du f&aring;r inte anv&auml;nda kommunikationstj&auml;nsterna p&aring; Matchadirekt till att sprida copyrightskyddat eller p&aring; annat s&auml;tt otill&aring;tet material. Du skall vidare inte s&auml;nda eller sprida material som kan skada eller orsaka st&ouml;rningar p&aring; en arbetsgivares dator eller som g&ouml;r att obeh&ouml;riga f&aring;r &aring;tkomst till programvara eller webbplatser. Administrat&ouml;rerna p&aring; Matchadirekt kan n&auml;r som helst, utan f&ouml;rvarning, ta bort inneh&aring;ll om n&aring;gon av ovanst&aring;ende regler bryts. Brott som beg&aring;s polisanm&auml;ls.</p>\r\n\r\n<p>Allt material som laddas upp i profiler och CV ska f&ouml;lja svensk lag. Matchadirekt ansvarar inte f&ouml;r den enskildes beteende inom Matchadirekt men tillskriver sig r&auml;tten att avveckla profilinnehavarens tillg&aring;ng till tj&auml;nsten om det beh&ouml;vs.</p>\r\n\r\n<p>&sect; 11 Giltighetstid</p>\r\n\r\n<p>Villkoren f&ouml;r denna tj&auml;nst kan i framtiden komma att &auml;ndras. Vid en f&ouml;r&auml;ndring av villkoren kommer du som anv&auml;ndare att informeras om &auml;ndringen n&auml;sta g&aring;ng tj&auml;nsten ska anv&auml;ndas. Du ges vid inloggning m&ouml;jlighet att godk&auml;nna villkors&auml;ndringen innan tj&auml;nsten nyttjas.</p>', NULL, 0, '2018-05-10 19:05:51', 'Published', 'Privacy Policy', 'Privacy, policies', 'Job portal privacy policies', 1, NULL, NULL, NULL, NULL),
(17, 'Privacy Notice', 'privacy-notice.html', '<p style=\'font-size:14px;\'><br />\r\nSekretess uppgifter:<br />\r\nJag har godk&auml;nt att uppgifterna lagras enligt: <a style=\"cursor:pointer;\" onclick=\"$(\'#p_p\').modal(\'show\');\">Integritetspolicy</a></p>', NULL, 0, '2018-05-10 20:07:44', 'Published', 'Privacy Notice', 'Privacy,Notice', 'Privacy Notice to use BiXma', 1, NULL, NULL, NULL, NULL),
(18, 'test', 'test.html', '<div style=\'width: 700px;max-width: 700px;\n    margin: auto;\' id=\'canvas\'>\n        <div class=\'companyinfoWrp\'>\n\n        <h1 class=\'jobname\'>Developer</h1>\n        <div class=\'jobthumb\'><img src=\'http://vps47202.lws-hosting.com/public/uploads/employer/JOBPORTAL-1516898144.png\' /></div>\n        <div class=\'jobloc\'><h3>Bixma</h3>\n        </div>\n        <div class=\'clear\'></div>\n        </div>\n        </div>', NULL, 0, '2018-02-05 20:27:12', 'Published', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL),
(19, 'default_job_analysis', 'default_job_analysis.html', '<p><big><strong>Demo NOTE:&nbsp;You can edit this default content on admin CMS page (default_job_analysis.html?</strong></big></p>\r\n\r\n<p><strong>Job Title: &nbsp; &nbsp; &nbsp;</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n<strong>Classification: </strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n<strong>Department/Division</strong>: &nbsp;<br />\r\n<strong>Location:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\r\n<strong>Pay Grade:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Job Requirements</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Summary of Position</li>\r\n</ul>\r\n\r\n<p><em>Researches and identifies target client sectors for financial product services. Develops and implements a sales process to include initial contact, follow up, presentation and closing procedures. Maintains records of contacts and sales status including contact reports, sales projections and quota ratios.</em></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li>B. Job Duties<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Research and Create targeted new client lists within Orange County California territory<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Makes initial contact with potential clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Performs routine and regular follow up with potential clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 4) Performs routine and regular follow up with former clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 5) Visits potential clients and makes sales presentations<br />\r\n	<br />\r\n	&nbsp; &nbsp; 6) Closes sales<br />\r\n	<br />\r\n	&nbsp; &nbsp; 7) Maintains regular record reporting sales activity<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>C. Computer Skills and Software Used<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Windows operating system<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) MS Office including Word, Excel and PowerPoint<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Constant Contact or other Customer Relations Management Software<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>D. Reporting Structure<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Reports to regional sales manager<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Has nobody directly reporting to this position<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Required to participate in Annual Sales Meeting</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Employee Requirements</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Education and Training<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Bachelor Degree in business, finance or accounting or 5 Years experience and High School Diploma. Bachelors Degree Preferred<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) ABC Financial Planning - Level 3 or higher (Fictional)<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>B. Skills and Aptitudes<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Fearless cold caller, 250+ Outbound calls per week<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Ability to close a sale<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3. Adapt to changing financial conditions and meet customer expectations<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>C. Environment and Physical<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Work in high volume sales office<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Be able to sit for prolonged periods of time<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Be able to travel to client locations 25% of time<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>D. Licenses/Certifications<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) CFP - Certified Financial Planner<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) California Drivers License<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Success Factors</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Grow Sales<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Increase market channel penetration by 30% in first Year<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Develop 3 secondary channels in first 180 days<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Grow referral-based sales from 15% to 20% in first year<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>B. Develop Sales Department<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Recruit and train 2 junior sales associates with gross sales of $500K by 3nd quarter<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Increase number of sales presentations by 20% within 12 months<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Implement Web-Meeting presentation System to Reduce travel costs by 20% per year</li>\r\n</ul>\r\n\r\n<p><br />\r\n<br />\r\nComments____________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>____________________________________________________</p>\r\n\r\n<p>____________________________________________________</p>\r\n\r\n<p><br />\r\n&nbsp;</p>\r\n\r\n<p>HR Representative___________________________________</p>\r\n\r\n<p>Department Manager__________________________________</p>\r\n\r\n<p>Date Completed______________________________________</p>', NULL, 0, '2018-02-07 12:26:23', 'Inactive', 'Job Analysis template', 'job, analysis', 'job, analysis', 1, NULL, NULL, NULL, NULL),
(20, 'default_employer_certificate', 'default_employer_certificate.html', '<p>Default Employer Certificate</p>', NULL, 0, '2018-02-12 21:29:03', 'Inactive', 'Default Employer Certificate', 'Default Employer Certificate', 'Default Employer Certificate', 1, NULL, NULL, NULL, NULL),
(21, 'default_interview', 'default_interview.html', '<p>Default Interview</p>', NULL, 0, '2018-02-12 22:29:28', 'Inactive', 'Default Interview', 'Default Interview', 'Default Interview', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `ID` int(11) NOT NULL,
  `company_name` varchar(155) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_ceo` varchar(60) DEFAULT NULL,
  `industry_ID` int(5) DEFAULT NULL,
  `ownership_type` enum('NGO','Private','Public') DEFAULT 'Private',
  `company_description` text,
  `company_location` varchar(155) DEFAULT NULL,
  `no_of_offices` int(11) DEFAULT NULL,
  `company_website` varchar(155) DEFAULT NULL,
  `no_of_employees` varchar(15) DEFAULT NULL,
  `established_in` varchar(12) DEFAULT NULL,
  `company_type` varchar(60) DEFAULT NULL,
  `company_fax` varchar(30) DEFAULT NULL,
  `company_phone` varchar(30) DEFAULT NULL,
  `company_logo` varchar(155) DEFAULT NULL,
  `company_folder` varchar(155) DEFAULT NULL,
  `company_country` varchar(80) DEFAULT NULL,
  `sts` enum('blocked','pending','active') DEFAULT 'active',
  `company_city` varchar(80) DEFAULT NULL,
  `company_slug` varchar(155) DEFAULT NULL,
  `old_company_id` int(11) DEFAULT NULL,
  `old_employerlogin` varchar(100) DEFAULT NULL,
  `flag` varchar(5) DEFAULT NULL,
  `ownership_type` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`ID`, `company_name`, `company_email`, `company_ceo`, `industry_ID`, `ownership_type`, `company_description`, `company_location`, `no_of_offices`, `company_website`, `no_of_employees`, `established_in`, `company_type`, `company_fax`, `company_phone`, `company_logo`, `company_folder`, `company_country`, `sts`, `company_city`, `company_slug`, `old_company_id`, `old_employerlogin`, `flag`, `ownership_type`) VALUES
(217, 'Domstolsverket', NULL, NULL, 42, 'Private', 'ngnghphg+hbpfbnböbn', 'ksfknvönvsbnfb', NULL, 'www.domstol.se', '301-600', NULL, NULL, NULL, '01286483446', 'JOBPORTAL-1517320097.jpg', NULL, NULL, 'active', NULL, 'domstolsverket', NULL, NULL, NULL, 'Private'),
(209, 'Bixma', NULL, NULL, 22, 'Private', 'IT company', 'Stockholn', NULL, 'www.bixma.com', '11-50', NULL, NULL, NULL, '0046700775775', 'JOBPORTAL-1522703219.png', NULL, NULL, 'active', NULL, 'bixma', NULL, NULL, NULL, 'Private'),
(210, 'Travos AB', NULL, NULL, 35, 'Private', 'Utbildning och arbetsmarknadsinsatser.', 'Centralvägen 1, 171 68 Solna', NULL, 'www.travos.se', '1-10', NULL, NULL, NULL, '+3221498347928', '', NULL, NULL, 'active', NULL, 'travos-ab', NULL, NULL, NULL, 'Private'),
(211, 'Attunda tingsrätt', NULL, NULL, 42, 'Private', 'Attunda tingsrätt bildades den 1 april 2007. Tingsrätten är en sammanslagning av Sollentuna och Södra Roslags tingsrätter, exklusive Lidingö kommun som numer tillhör Stockholms tingsrätt.\r\nAttunda tingsrätt är sedan den 12 april 2010 beläget i ett nybyggt tingshus vid Sollentuna centrum. Verksamheten vid de två tidigare kansliorterna Gärdet och Sollentuna upphörde vid samma tidpunkt.', 'Tingsvägen 11,  191 61 Sollentuna', NULL, 'www.attundatingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990014.jpg', NULL, NULL, 'active', NULL, 'attunda-tingsrtt', NULL, NULL, NULL, 'Government'),
(212, 'Göteborgs tingsrätt', NULL, NULL, 42, 'Private', 'Vid Göteborgs tingsrätt tjänstgör omkring 210 personer. Tingsrätten är uppdelad i fyra avdelningar som handlägger både brottmål och tvistemål samt eko-brottmål. Dessutom har tingsrätten en konkursenhet.', 'Ullevigatan 15', NULL, 'www.goteborgstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990431.png', NULL, NULL, 'active', NULL, 'gteborgs-tingsrtt', NULL, NULL, NULL, 'Government'),
(213, 'Jönköpings tingsrätt', NULL, NULL, 42, 'Private', 'Sveriges Domstolar är samlingsnamnet för domstolarnas verksamhet. Sveriges Domstolar omfattar de allmänna domstolarna, de allmänna förvaltningsdomstolarna, hyres- och arrendenämnderna, Rättshjälpsmyndigheten, Rättshjälpsnämnden och Domstolsverket.', 'Hamngatan 15, 553 16 Jönköping', NULL, 'www.jonkopingstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990788.png', NULL, NULL, 'active', NULL, 'jnkpings-tingsrtt', NULL, NULL, NULL, 'Government'),
(214, 'Linköpings tingsrätt', NULL, NULL, 42, 'Private', 'Tingsrätten handlägger bland annat brottmål, tvistemål och familjerättsliga mål. Vi handlägger också konkurser och ansökningar om till exempel god man och bodelningsförrättare.', 'Brigadgatan 3, 587 58 Linköping', NULL, 'www.linkopingstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991082.png', NULL, NULL, 'active', NULL, 'linkpings-tingsrtt', NULL, NULL, NULL, 'Government'),
(215, 'Eskilstuna tingsrätt', NULL, NULL, 42, 'Private', 'Tingsrätten har 40 anställda. Domsagan omfattar Eskilstuna och Strängnäs kommuner med en sammanlagd befolkningsmängd av drygt 130 000 invånare. Tingsrätten är organiserad i två målenheter och en administrativ enhet. Varje målenhet har en samordnande rådman. Till målenhet 1 hör också konkursavdelningen.', 'Rademachergatan 8 632 20 Eskilstuna', NULL, 'www.eskilstunatingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991298.png', NULL, NULL, 'active', NULL, 'eskilstuna-tingsrtt', NULL, NULL, NULL, 'Government'),
(216, 'Malmö Tingsrätt', NULL, NULL, 42, 'Private', 'Malmö tingsrätt är en allmän domstol som handlägger brottmål, tvistemål, ärenden och konkurser. Tingsrätten är sjörättsdomstol med domkrets enligt sjölagen och domstol i tryckfrihetsmål, yttrandefrihetsmål och mål enligt lagen (2002:599) om grupprättegång m m i Skåne län. Tingsrätten är organiserad i fyra målavdelningar och en administrativ enhet och har ca 150 anställda.', 'Kalendegatan 1, 211 35 Malmö', NULL, 'www.malmotingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991464.png', NULL, NULL, 'active', NULL, 'malm-tingsrtt', NULL, NULL, NULL, 'Government'),
(218, 'Oki', NULL, NULL, 7, 'Private', 'Dgvvcxhb', 'Vbb', NULL, '13', '101-300', NULL, NULL, NULL, '0674388739', 'JOBPORTAL-1527722189.png', NULL, NULL, 'active', NULL, 'oki', NULL, NULL, NULL, 'Private'),
(219, 'asa', NULL, NULL, 5, 'Private', 'as', 'asa', NULL, 'as', '1-10', NULL, NULL, NULL, 'aassa', 'JOBPORTAL-1524845926.png', NULL, NULL, 'active', NULL, 'asa', NULL, NULL, NULL, 'Semi-Government'),
(220, 'Travos AB', NULL, NULL, 35, 'Private', 'Välkomna till Travos AB!\n\nVårt uppdrag är att hjälpa ungdomar, studenter, långtidsarbetslösa samt nyanlända att lämna arbetslösheten och etablera sig snabbt på arbetsmarknaden. \nMålsättningen med vår verksamhet är att delta i den globaliserade kunskapsutvecklingen som aktör och påverka den svenska arbetsmarknaden i syfte att tillvarata varje individs unika kunskaper samt möjligheter!\nVi samarbetar med Arbetsförmedlingen, företag, ideella organisationer och olika kommuner för att hjälpa våra deltagare att integrera sig i Sverige, samt att etablera sig snabbt på arbetsmarknaden. \nVår filosofi är att alltid tänka efter och före, på så sätt vet vi att vi skapar ett mervärde för våra kunder. \nVi eftersträvar att alltid vara så effektiva som möjligt; ekonomiskt, tidsmässigt och kvalitetsmässigt.', 'Centralvägen 1, 171 68 Solna', NULL, 'www.travos.se', '1-10', NULL, NULL, NULL, '08-734 92 40', 'JOBPORTAL-1528392698.jpeg', NULL, NULL, 'active', NULL, 'travos-ab-1528392698', NULL, NULL, NULL, 'Private'),
(221, 'Bixma', NULL, NULL, 22, 'Private', ';nophigo8f97d87s', 'company address', NULL, 'www.company.com', '1-10', NULL, NULL, NULL, '0700775775', 'JOBPORTAL-1533571366.jpg', NULL, NULL, 'active', NULL, 'bixma-1533571366', NULL, NULL, NULL, 'Private'),
(222, 'qewrqwer', NULL, NULL, 18, 'Private', 'qewrqwerqwer', 'qwerqwerqwer', NULL, 'qwerqwer', 'More than 2000', NULL, NULL, NULL, 'qewrqwer', 'JOBPORTAL-1533810870.jpg', NULL, NULL, 'active', NULL, 'qewrqwer', NULL, NULL, NULL, 'Private');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_conversation`
--

CREATE TABLE `tbl_conversation` (
  `id_conversation` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_conversation`
--

INSERT INTO `tbl_conversation` (`id_conversation`, `id_employer`, `id_job_seeker`, `created_at`) VALUES
(3, 209, 423, '2018-01-25 10:36:22'),
(4, 209, 425, '2018-01-26 12:28:04'),
(5, 216, 427, '2018-01-26 13:17:54'),
(6, 209, 427, '2018-01-26 13:40:46'),
(7, 215, 430, '2018-01-28 05:09:27'),
(8, 211, 430, '2018-01-28 05:09:39'),
(9, 213, 430, '2018-01-28 05:09:45'),
(10, 210, 424, '2018-01-28 11:54:36'),
(11, 0, 429, '2018-01-29 15:48:51'),
(12, 209, 449, '2018-01-30 06:30:58'),
(13, 215, 427, '2018-01-30 08:48:59'),
(14, 209, 10, '2018-02-13 23:24:23'),
(15, 209, 448, '2018-02-27 23:07:20'),
(16, 218, 424, '2018-05-18 04:50:17'),
(17, 221, 462, '2018-06-07 12:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_conv_message`
--

CREATE TABLE `tbl_conv_message` (
  `id_conv_message` int(11) NOT NULL,
  `id_conversation` int(11) DEFAULT NULL,
  `id_sender` int(11) DEFAULT NULL,
  `message` text,
  `type_sender` varchar(50) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT '0',
  `seen_at` datetime DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_conv_message`
--

INSERT INTO `tbl_conv_message` (`id_conv_message`, `id_conversation`, `id_sender`, `message`, `type_sender`, `seen`, `seen_at`, `sent_at`) VALUES
(16, 3, 209, 'Test to messaging system.', 'employers', 0, NULL, '2018-01-25 10:36:22'),
(17, 3, 209, 'jOB SEEKER REPLY TEST', 'job_seekers', 0, NULL, '2018-01-25 10:49:25'),
(18, 3, 209, 'New send thru system sent botton', 'employers', 0, NULL, '2018-01-25 11:05:56'),
(19, 4, 209, 'We have a new job that might be of your interest! Check it on our company profile.', 'employers', 0, NULL, '2018-01-26 12:28:04'),
(20, 5, 216, 'hi', 'employers', 0, NULL, '2018-01-26 13:17:54'),
(21, 3, 209, 'kifak', 'employers', 0, NULL, '2018-01-26 13:40:11'),
(22, 6, 209, 'kifak', 'employers', 0, NULL, '2018-01-26 13:40:46'),
(23, 6, 209, 'mnee7\r\n', 'job_seekers', 0, NULL, '2018-01-26 13:41:06'),
(24, 5, 216, 'ahlan\r\n', 'job_seekers', 0, NULL, '2018-01-26 13:41:20'),
(25, 6, 209, 'ba3d ma wislit\r\n', 'employers', 0, NULL, '2018-01-26 13:41:29'),
(26, 6, 209, 'hallaa wislit', 'employers', 0, NULL, '2018-01-26 13:41:42'),
(27, 6, 209, 'ahlen', 'job_seekers', 0, NULL, '2018-01-26 13:41:58'),
(28, 7, 215, 'HEj hEJ hEJ ', 'employers', 0, NULL, '2018-01-28 05:09:27'),
(29, 8, 211, 'Du är anställd! När kan du börja', 'employers', 0, NULL, '2018-01-28 05:09:39'),
(30, 9, 213, 'Hello chefen!', 'employers', 0, NULL, '2018-01-28 05:09:45'),
(31, 9, 213, 'Hej Företag!\r\n', 'job_seekers', 0, NULL, '2018-01-28 05:10:29'),
(32, 8, 211, 'HEJ', 'job_seekers', 0, NULL, '2018-01-28 05:10:35'),
(33, 8, 211, 'När kan du börja?', 'employers', 0, NULL, '2018-01-28 05:13:58'),
(34, 8, 211, 'Hej!', 'employers', 0, NULL, '2018-01-28 06:19:32'),
(35, 10, 210, 'hi', 'employers', 0, NULL, '2018-01-28 11:54:36'),
(36, 10, 210, 'hello popy', 'job_seekers', 0, NULL, '2018-01-28 12:07:50'),
(37, 10, 210, 's', 'employers', 0, NULL, '2018-01-28 12:41:49'),
(39, 10, 210, 'salut ', 'employers', 0, NULL, '2018-01-28 13:12:17'),
(40, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-file-o\'>&nbsp;</i>\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47202.lws-hosting.com/employer/chat/download/Attached_file_BiXma-14ab33aca6eb7e8d9e818b360e9da316.docx\'>Attached File<br></a>', 'employers', 0, NULL, '2018-01-28 13:12:17'),
(41, 10, 210, 'sasa', 'employers', 0, NULL, '2018-01-28 13:12:36'),
(42, 10, 210, 'ss', 'employers', 0, NULL, '2018-01-28 13:13:58'),
(43, 10, 210, 's', 'employers', 0, NULL, '2018-01-28 13:16:25'),
(44, 10, 210, 'Bonsoir this is a fucking file', 'employers', 0, NULL, '2018-01-28 13:18:12'),
(45, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-file-o\'>&nbsp;</i>\r\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47202.lws-hosting.com/employer/chat/download/Attached_file_BiXma-d0bf801d90d917c3e70be733982a3c28.docx\'>Attached File<br></a>', 'employers', 0, NULL, '2018-01-28 13:18:12'),
(46, 10, 210, 'sa', 'job_seekers', 0, NULL, '2018-01-28 13:40:41'),
(47, 10, 210, 'sa', 'job_seekers', 0, NULL, '2018-01-28 13:45:36'),
(48, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-download\'>&nbsp;</i>\r\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47202.lws-hosting.com/chat/download/Attached_file_BiXma-ba5357e7e08c7428d588d11437993633.doc\'>Attached File<br></a>', 'job_seekers', 0, NULL, '2018-01-28 13:49:39'),
(49, 11, 0, 'idb abjVNvnIUVA', 'employers', 0, NULL, '2018-01-29 15:48:51'),
(50, 12, 209, 'iqougyq ', 'employers', 0, NULL, '2018-01-30 06:30:58'),
(51, 12, 209, 'k;jhugfu', 'employers', 0, NULL, '2018-01-30 06:36:18'),
(52, 8, 211, 'Hej', 'employers', 0, NULL, '2018-01-30 08:25:57'),
(53, 8, 211, 'Hur funkar den här funktionen?', 'employers', 0, NULL, '2018-01-30 08:26:23'),
(54, 13, 215, 'Hej, Tack för din ansökan. Vi vill gärna att du kompletterar med följande: Löneanspråk, referensperson samt ett intyg från avslutad kurs på Högskolan. \r\n\r\nHälsningar \r\n', 'employers', 0, NULL, '2018-01-30 08:48:59'),
(55, 7, 215, 'Eskilstuna tingsrätt\r\n', 'employers', 0, NULL, '2018-01-30 11:46:22'),
(56, 7, 215, 'Eskilstuna tingsrätt ', 'employers', 0, NULL, '2018-01-30 11:46:30'),
(57, 7, 215, 'Eskilstuna Tingsrätt ', 'employers', 0, NULL, '2018-01-30 11:46:45'),
(58, 7, 215, 'Eskilstuna Tingsrätt ', 'employers', 0, NULL, '2018-01-30 11:46:45'),
(59, 7, 215, 'Hej! Här med vill vi meddela att ansökan är öppen kommande veckan även fast ansökningsdatumet har passerat. ', 'employers', 0, NULL, '2018-01-30 11:55:49'),
(60, 7, 215, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-file-o\'>&nbsp;</i>\r\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47202.lws-hosting.com/employer/chat/download/Attached_file_BiXma-f8744699348d56ebc15816796e64f4fc.pdf\'>Attached File<br></a>', 'employers', 0, NULL, '2018-01-30 12:45:13'),
(61, 8, 211, 'Hej! Du är kallad på intervju 05/02-2018\r\n', 'employers', 0, NULL, '2018-01-30 15:57:20'),
(67, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-link\'>&nbsp;</i>\r\n                  <a onclick=\"showMe(\'Big Five Personality Test\',\'https://openpsychometrics.org/tests/IPIP-BFFM/\')\" style=\'text-decoration: none;color: white;\' href=\'#\'>Personality test<br/><small>Big Five Personality Test</small></a>', 'employers', 0, NULL, '2018-01-30 17:53:42'),
(68, 12, 209, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-link\'>&nbsp;</i>\r\n                  <a onclick=\"showMe(\'Big Five Personality Test\',\'https://openpsychometrics.org/tests/IPIP-BFFM/\')\" style=\'text-decoration: none;color: white;\' href=\'#\'>Personality test<br/><small>Big Five Personality Test</small></a>', 'employers', 0, NULL, '2018-01-30 22:52:16'),
(69, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-download\'>&nbsp;</i>\r\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47517.lws-hosting.com/chat/download/Attached_file_BiXma-afb960ff3602ed3c7cdd95ebac86814b.rtf\'>Attached File<br></a>', 'job_seekers', 0, NULL, '2018-02-12 11:16:07'),
(70, 14, 209, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-link\'>&nbsp;</i>\r\n                  <a onclick=\"showMe(\'Open Extended Jungian Type Scales\',\'https://openpsychometrics.org/tests/OEJTS/\')\" style=\'text-decoration: none;color: white;\' href=\'#\'>Personality test<br/><small>Open Extended Jungian Type Scales</small></a>', 'employers', 0, NULL, '2018-02-13 23:24:23'),
(71, 10, 210, 'Hi Invite', 'employers', 0, NULL, '2018-02-16 12:21:41'),
(72, 10, 210, 'Hi , please take a look at this Job<br/><a href=\"http://vps47517.lws-hosting.com/job/travos-ab-jobs-in-n.a-laravel-developer-115\"><i class=\"fa fa-link\"></i> Laravel Developer</a>', 'employers', 0, NULL, '2018-02-16 12:29:30'),
(73, 10, 210, 'Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"http://vps47517.lws-hosting.com/job/travos-ab-jobs-in-n.a-laravel-developer-115\"><i class=\"fa fa-link\"></i> Laravel Developer</a>', 'employers', 0, NULL, '2018-02-16 12:29:57'),
(74, 10, 210, 'Hi , please take a look at this Jobs<br/><a target=\"_blank\" href=\"http://vps47517.lws-hosting.com/job/travos-ab-jobs-in-n.a-lrare-116\"><i class=\"fa fa-link\"></i> Lärare</a>', 'employers', 0, NULL, '2018-02-16 12:30:24'),
(75, 10, 210, 'Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"http://vps47517.lws-hosting.com/jobs/travos-ab-jobs-in-n.a-lrare-116\"><i class=\"fa fa-link\"></i> Lärare</a>', 'employers', 0, NULL, '2018-02-16 12:31:09'),
(76, 10, 210, 'salam\r\nHi', 'employers', 0, NULL, '2018-02-24 10:38:06'),
(77, 10, 210, 'ssa', 'employers', 0, NULL, '2018-02-24 10:38:44'),
(78, 10, 210, 'sa', 'employers', 0, NULL, '2018-02-24 10:39:52'),
(79, 10, 210, 'sa', 'employers', 0, NULL, '2018-02-24 10:40:53'),
(80, 10, 210, 'Hi', 'employers', 0, NULL, '2018-02-24 10:45:15'),
(81, 10, 210, 'No body', 'employers', 0, NULL, '2018-02-24 10:52:02'),
(82, 10, 210, 'Hi', 'job_seekers', 0, NULL, '2018-02-24 10:53:00'),
(83, 10, 210, 'ffdzdazdaz', 'job_seekers', 0, NULL, '2018-02-24 10:55:33'),
(84, 10, 210, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-download\'>&nbsp;</i>\r\n                  <a style=\'text-decoration: none;color: white;\' href=\'http://vps47517.lws-hosting.com/chat/download/Attached_file_BiXma-1e5d9d80c5192e42ada57a8c25b89c98.png\'>Attached File<br></a>', 'job_seekers', 0, NULL, '2018-02-24 10:55:33'),
(85, 15, 209, '<i style=\'text-decoration: none;color: white;\' class=\'fa fa-link\'>&nbsp;</i>\r\n                  <a onclick=\"showMe(\'Open Extended Jungian Type Scales\',\'https://openpsychometrics.org/tests/OEJTS/\')\" style=\'text-decoration: none;color: white;\' href=\'#\'>Personality test<br/><small>Open Extended Jungian Type Scales</small></a>', 'employers', 0, NULL, '2018-02-27 23:07:20'),
(86, 15, 209, 'Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"http://vps47517.lws-hosting.com/jobs/bixma-jobs-in-stockholm-bmce-dg-145\"><i class=\"fa fa-link\"></i> Bmce Dg</a>', 'employers', 0, NULL, '2018-02-27 23:09:32'),
(87, 10, 210, 'Hi\r\n', 'employers', 0, NULL, '2018-02-28 00:14:23'),
(88, 16, 218, 'sasa', 'employers', 0, NULL, '2018-05-18 04:50:17'),
(89, 8, 211, 'Hej!', 'employers', 0, NULL, '2018-05-21 04:51:18'),
(90, 17, 221, 'Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"https://matchadirekt.com/jobs/travos-ab-1528392698-jobs-in-solna-handledare-151\"><i class=\"fa fa-link\"></i> Handledare</a>', 'employers', 0, NULL, '2018-06-07 12:42:11'),
(91, 17, 221, 'Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"https://matchadirekt.com/jobs/travos-ab-1528392698-jobs-in-solna-handledare-151\"><i class=\"fa fa-link\"></i> Handledare</a>', 'employers', 0, NULL, '2018-06-08 04:11:06'),
(92, 17, 221, 'Hej ', 'job_seekers', 0, NULL, '2018-06-14 05:24:33'),
(93, 17, 221, 'Hej Frida!', 'job_seekers', 0, NULL, '2018-08-13 07:44:14'),
(94, 17, 221, 'Hej Frida!', 'employers', 0, NULL, '2018-08-13 07:45:02'),
(95, 17, 221, 'HEJ\r\n', 'employers', 0, NULL, '2018-08-13 07:50:22'),
(96, 17, 221, 'HEJ', 'job_seekers', 0, NULL, '2018-08-13 07:50:37'),
(97, 17, 221, 'Hej Frida! Såg att du söker arbetet som handledare är det något du har tidigare erfarenhet som?\r\n', 'employers', 0, NULL, '2018-08-13 07:54:55'),
(98, 17, 221, 'Hej ! tyvärr är det inget jag har tidigare erfarenhet av men vill lära mig nya saker och söker mig därför till er och arbetet ni har att erbjuda på travos', 'job_seekers', 0, NULL, '2018-08-13 07:56:32'),
(99, 17, 221, '.\r\n', 'job_seekers', 0, NULL, '2018-08-13 07:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `ID` int(11) NOT NULL,
  `country_name` varchar(150) NOT NULL DEFAULT '',
  `country_citizen` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`ID`, `country_name`, `country_citizen`) VALUES
(8, 'Sverige', 'Sverige');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_content`
--

CREATE TABLE `tbl_email_content` (
  `ID` int(11) NOT NULL,
  `email_name` varchar(155) DEFAULT NULL,
  `from_name` varchar(155) DEFAULT NULL,
  `content` text,
  `from_email` varchar(90) DEFAULT NULL,
  `subject` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_content`
--

INSERT INTO `tbl_email_content` (`ID`, `email_name`, `from_name`, `content`, `from_email`, `subject`) VALUES
(1, 'Forgot Password', 'BiXma Job System', '<style type=\"text/css\">\r\n				.txt {\r\n						font-family: Arial, Helvetica, sans-serif;\r\n						font-size: 13px; color:#000000;\r\n					}\r\n				</style>\r\n<p class=\"txt\">Thank you  for contacting Member Support. Your account information is listed below: </p>\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" class=\"txt\">\r\n  <tr>\r\n    <td width=\"17\" height=\"19\"><p>&nbsp;</p></td>\r\n    <td width=\"159\" height=\"25\" align=\"right\"><strong>Login Page:&nbsp;&nbsp;</strong></td>\r\n    <td width=\"424\" align=\"left\"><a href=\"{SITE_URL}/login\">{SITE_URL}/login</a></td>\r\n  </tr>\r\n  <tr>\r\n    <td height=\"19\">&nbsp;</td>\r\n    <td height=\"25\" align=\"right\"><strong>Your Username:&nbsp;&nbsp;</strong></td>\r\n    <td align=\"left\">{USERNAME}</td>\r\n  </tr>\r\n  <tr>\r\n    <td height=\"19\"><p>&nbsp;</p></td>\r\n    <td height=\"25\" align=\"right\"><strong>Your Password:&nbsp;&nbsp;</strong></td>\r\n    <td align=\"left\">{PASSWORD}</td>\r\n  </tr>\r\n</table>\r\n\r\n<p class=\"txt\">Thank you,</p>', 'support@bixma.com', 'Password Recovery'),
(2, 'Jobseeker Signup', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n\r\n  <p>{JOBSEEKER_NAME}:</p>\r\n  <p>Thank you for joining us. Please note your profile details for future record.</p>\r\n  <p>Username: {USERNAME}<br>\r\n    Password: {PASSWORD}</p>\r\n  <a href=\"{LINK}\">Confirmation</a>\r\n  <p>Regards</p>', 'support@bixma.com', 'New Job Seeker Account'),
(3, 'Employer signs up', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n\r\n  <p>{EMPLOYER_NAME}</p>\r\n  <p>Thank you for joining us. Please note your profile details for future record.</p>\r\n  <p>Username: {USERNAME}<br>\r\n    Password: {PASSWORD}</p>\r\n  <p>Regards</p>', 'support@bixma.com', 'New Employer Account'),
(4, 'New job is posted by Employer', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n\r\n  <p>{JOBSEEKER_NAME},</p>\r\n  <p>We would like to inform  that a new job has been posted on our website that may be of your interest.</p>\r\n  <p>Please visit the  following link to review and apply:</p>\r\n <p>{JOB_LINK}</p>\r\n  <p>Regards,</p>', 'support@bixma.com', 'New {JOB_CATEGORY}'),
(5, 'Apply Job', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n  <p>{EMPLOYER_NAME}:</p>\r\n  <p>A new candidate has applied for the post of {JOB_TITLE}.</p>\r\n  <p>Please visit the following link to review the applicant profile.<br>\r\n    {CANDIDATE_PROFILE_LINK}</p>\r\n  <p>Regards,</p>', 'support@bixma.com', 'New Job CV {JOB_TITLE}'),
(6, 'Job Activation Email', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n  <p>{EMPLOYER_NAME}:</p>\r\n  <p>You had recently posted a job: {JOB_TITLE} on our website.</p>\r\n  <p>Your recent job has been approved and should be displaying on our website.</p>\r\n  <p>Thank you for using our website.</p>\r\n  <p>Regards,</p>', 'support@bixma.com', '{JOB_TITLE}  is now active'),
(7, 'Send Message To Candidate', 'BiXma Job System', '<style type=\"text/css\">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n  <p>Hi {JOBSEEKER_NAME}:</p>\r\n  <p>A new message has been posted for you by :  {COMPANY_NAME}.</p>\r\n  <p>Message:</p>\r\n  <p>{MESSAGE}</p>\r\n  <p>You may review this company by going to: {COMPANY_PROFILE_LINK} to company profile.</p>\r\n  \r\n  <p>Regards,</p>', 'support@bixma.com', 'New message for you'),
(8, 'Scam Alert', 'BiXma Job System', 'bla bla bla', 'support@bixma.com', 'Company reported');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employers`
--

CREATE TABLE `tbl_employers` (
  `ID` int(11) NOT NULL,
  `company_ID` int(6) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pass_code` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `mobile_phone` varchar(30) NOT NULL DEFAULT '',
  `gender` enum('female','male','other') DEFAULT NULL,
  `dated` date NOT NULL,
  `sts` enum('blocked','pending','active') NOT NULL DEFAULT 'active',
  `dob` date DEFAULT NULL,
  `home_phone` varchar(30) DEFAULT NULL,
  `verification_code` varchar(155) DEFAULT NULL,
  `first_login_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  `old_emp_id` int(11) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `present_address` varchar(155) DEFAULT NULL,
  `top_employer` enum('no','yes') DEFAULT 'no',
  `channel` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employers`
--

INSERT INTO `tbl_employers` (`ID`, `company_ID`, `email`, `pass_code`, `first_name`, `last_name`, `country`, `city`, `mobile_phone`, `gender`, `dated`, `sts`, `dob`, `home_phone`, `verification_code`, `first_login_date`, `last_login_date`, `ip_address`, `old_emp_id`, `flag`, `present_address`, `top_employer`, `channel`) VALUES
(217, 217, 'sara.sundelinronquist@dom.se', 'Domstol', 'Sara', NULL, 'Sweden', '55422', '934937348038', NULL, '0000-00-00', 'active', NULL, NULL, NULL, '2018-02-03 09:45:10', '2018-02-22 10:01:18', '159.190.240.1', NULL, NULL, NULL, 'no', ''),
(209, 209, 'bixmatech@gmail.com', 'test123', 'Bixma', NULL, 'Sweden', 'Stockholm', '0046700775775', NULL, '2018-01-25', 'active', NULL, NULL, NULL, '2018-01-25 10:45:06', '2018-09-14 11:59:16', '90.224.199.144', NULL, NULL, NULL, 'yes', ''),
(223, 222, 'ravinderpuri.waveinfotech.biz@gmail.com', '123456', 'qwerwqer', NULL, 'Sverige', 'qwerqwer', 'qwerqwer', NULL, '2018-08-09', 'active', NULL, NULL, NULL, NULL, NULL, '122.173.62.21', NULL, NULL, NULL, 'no', 'Channel 2'),
(221, 220, 'info@travos.se', 'Lattis76', 'Timeo Skarander', NULL, 'Sverige', 'Solna', '0723189657', NULL, '2018-06-07', 'active', NULL, NULL, NULL, '2018-06-08 04:08:39', '2018-06-23 07:13:51', '83.183.12.57', NULL, NULL, NULL, 'no', 'Channel 1'),
(212, 212, 'mimosweden@gmail.com', 'mimo123', 'Göteborgs tingsrätt', NULL, 'Sweden', 'Göteborg', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', ''),
(213, 213, 'libanesen@hotmail.com', 'mimo123', 'Jönköpings tingsrätt', NULL, 'Sweden', 'Jönköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-27 07:27:49', '2018-01-30 08:33:36', '83.183.12.57', NULL, NULL, NULL, 'yes', ''),
(214, 214, 'timeo.skarander@hotmail.com', 'mimo123', 'Linköpings tingsrätt', NULL, 'Sweden', 'Linköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', ''),
(215, 215, 'rekrytering@travos.se', 'mimo123', 'Eskilstuna tingsrätt', NULL, 'Sweden', 'Eskilstuna', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-28 04:14:32', '2018-02-27 23:00:04', '83.183.12.57', NULL, NULL, NULL, 'yes', ''),
(216, 216, 'sfi@travos.se', 'mimo123', 'Malmö Tingsrätt', NULL, 'Sweden', 'Malmö', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-30 01:29:17', '2018-01-30 02:45:41', '83.183.12.57', NULL, NULL, NULL, 'yes', ''),
(218, 217, 'b@b.com', 'b', 'Demo employer', NULL, 'Sweden', '55422', '934937348038', NULL, '2018-03-15', 'active', NULL, NULL, NULL, '2018-02-03 09:45:10', '2018-09-05 15:36:45', '159.190.240.1', NULL, NULL, NULL, 'no', ''),
(222, 221, 'ramzi@bixma.com', 'TEST123', 'BiXma', NULL, 'Sverige', 'SDERTLJE', '0700775775', NULL, '2018-08-06', 'active', NULL, NULL, NULL, '2018-08-06 11:14:19', '2018-08-06 11:20:01', '85.224.186.245', NULL, NULL, NULL, 'no', 'Channel 1'),
(220, 219, 'x@a.x', 'test123', 'Aeeas', NULL, 'Sverige', 'as', 'as', NULL, '2018-04-27', 'active', NULL, NULL, NULL, NULL, NULL, '105.155.218.208', NULL, NULL, NULL, 'no', 'Channel 2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employer_certificate`
--

CREATE TABLE `tbl_employer_certificate` (
  `ID` int(11) NOT NULL,
  `pageTitle` varchar(255) DEFAULT NULL,
  `pageSlug` varchar(255) DEFAULT NULL,
  `pageContent` text,
  `employer_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employer_certificate`
--

INSERT INTO `tbl_employer_certificate` (`ID`, `pageTitle`, `pageSlug`, `pageContent`, `employer_id`, `deleted`, `created_at`) VALUES
(6, 'saa', 'dde', '<p>?</p>\r\n\r\n<p>Default Employer Certificate</p>\r\n', 210, 1, '2018-02-12 22:32:56'),
(7, 'ffe', 'ggr', '<p>?2</p>\r\n\r\n<p>Default Employer Certificate</p>\r\n', 210, 0, '2018-02-12 22:31:58'),
(8, 'test employer certificate', 'ugifydt', '<p>?</p>\r\n\r\n<p>Default Employer Certificatekhlgoufiydtsryt</p>\r\n', 209, 0, '2018-02-16 16:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employer_files`
--

CREATE TABLE `tbl_employer_files` (
  `ID` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `employer_ID` int(11) DEFAULT NULL,
  `private` enum('no','yes') NOT NULL DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employer_files`
--

INSERT INTO `tbl_employer_files` (`ID`, `file_name`, `job_ID`, `employer_ID`, `private`, `created_at`, `deleted`) VALUES
(1, 'BiXma-Job-File-1451518562150.docx', 145, 209, 'yes', '2018-02-13 23:49:10', 1),
(2, 'BiXma-Job-File-1451518562253.pdf', 145, 209, 'no', '2018-02-13 23:50:53', 1),
(3, 'BiXma-Job-File-1451518563213.docx', 145, 209, 'no', '2018-02-14 00:06:53', 1),
(4, 'BiXma-Job-File-1451518563233.docx', 145, 209, 'no', '2018-02-14 00:07:13', 1),
(5, 'BiXma-Job-File-1451518563305.docx', 145, 209, 'yes', '2018-02-14 00:08:25', 1),
(6, 'BiXma-Job-File-1451518563390.pdf', 145, 209, 'no', '2018-02-14 00:09:50', 0),
(7, 'BiXma-Job-File-1451518563590.doc', 145, 209, 'no', '2018-02-14 00:13:10', 0),
(8, 'BiXma-Job-File-1161518564118.docx', 116, 210, 'no', '2018-02-14 00:21:58', 1),
(9, 'BiXma-Job-File-1161518601297.png', 116, 210, 'no', '2018-02-14 10:41:37', 1),
(10, 'BiXma-Job-File-1161518601326.png', 116, 210, 'no', '2018-02-14 10:42:06', 0),
(11, 'BiXma-Job-File-1161518601344.txt', 116, 210, 'yes', '2018-02-14 10:42:24', 0),
(12, 'BiXma-Job-File-1161518601361.pdf', 116, 210, 'no', '2018-02-14 10:42:41', 0),
(13, 'BiXma-Job-File-1451523656494.txt', 145, 209, 'no', '2018-04-13 16:54:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite_candidates`
--

CREATE TABLE `tbl_favourite_candidates` (
  `employer_id` int(11) NOT NULL,
  `seekerid` int(11) DEFAULT NULL,
  `employerlogin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite_companies`
--

CREATE TABLE `tbl_favourite_companies` (
  `seekerid` int(11) NOT NULL,
  `companyid` int(11) DEFAULT NULL,
  `seekerlogin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `ID` int(11) NOT NULL,
  `image_caption` varchar(150) DEFAULT NULL,
  `image_name` varchar(155) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `sts` enum('inactive','active') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`ID`, `image_caption`, `image_name`, `dated`, `sts`) VALUES
(1, 'Test', 'portfolio-2.jpg', '2015-09-05 18:16:41', 'active'),
(2, '', 'portfolio-1.jpg', '2015-09-05 21:17:59', 'active'),
(3, '', 'portfolio-3.jpg', '2015-09-05 21:22:19', 'active'),
(4, '', 'portfolio-6.jpg', '2015-09-05 21:22:29', 'active'),
(5, '', 'portfolio-7.jpg', '2015-09-05 21:22:38', 'active'),
(6, '', 'portfolio-8.jpg', '2015-09-05 21:22:53', 'active'),
(7, '', 'portfolio-9.jpg', '2015-09-05 21:23:05', 'active'),
(8, 'Walk with the Queen... But be careful!', 'portfolio-10.jpg', '2015-09-05 21:23:16', 'inactive'),
(9, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla.', 'portfolio-11.jpg', '2015-09-05 21:23:24', 'active'),
(10, 'Beatuiful Bubble', 'portfolio-12.jpg', '2015-09-05 21:23:32', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_institute`
--

CREATE TABLE `tbl_institute` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sts` enum('blocked','active') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_institute`
--

INSERT INTO `tbl_institute` (`ID`, `name`, `sts`) VALUES
(1, 'ANTS', NULL),
(2, 'test', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_interview`
--

CREATE TABLE `tbl_interview` (
  `ID` int(11) NOT NULL,
  `pageTitle` varchar(255) DEFAULT NULL,
  `pageSlug` varchar(255) DEFAULT NULL,
  `pageContent` text,
  `employer_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_interview`
--

INSERT INTO `tbl_interview` (`ID`, `pageTitle`, `pageSlug`, `pageContent`, `employer_id`, `deleted`, `created_at`) VALUES
(6, 'ineter', 'sssss', '<p><strong>Default Interview</strong></p>\r\n', 210, 0, '2018-04-23 16:27:31'),
(7, '22', '33', '<p>?ZSDZADZA</p>\r\n', 210, 0, '2018-02-12 22:33:53'),
(8, 'test interview', 'guifyldu', '<p>?</p>\r\n\r\n<p><font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">Default Interviewklycutxkrzt</font></font></p>\r\n', 209, 0, '2018-04-24 12:45:54'),
(9, '1', '123', '<html><head></head><body>ssssssss</body></html>', 210, 0, '2018-04-08 15:24:49'),
(10, 'CC', 'C', '<p>Default Interview</p>\r\n', 209, 0, '2018-04-22 09:48:46'),
(11, '/', 'm/l', '<p>Default Interview</p>\r\n', 209, 0, '2018-08-09 12:24:06'),
(12, 'ÖÄÅ', 'ÖÄÅ', '<p>&Ouml;&Auml;&Aring;</p>\r\n', 221, 0, '2018-09-04 08:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_alert`
--

CREATE TABLE `tbl_job_alert` (
  `ID` int(11) NOT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_alert_queue`
--

CREATE TABLE `tbl_job_alert_queue` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_analysis`
--

CREATE TABLE `tbl_job_analysis` (
  `ID` int(11) NOT NULL,
  `pageTitle` varchar(255) DEFAULT NULL,
  `pageSlug` varchar(255) DEFAULT NULL,
  `pageContent` text,
  `employer_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_analysis`
--

INSERT INTO `tbl_job_analysis` (`ID`, `pageTitle`, `pageSlug`, `pageContent`, `employer_id`, `deleted`, `created_at`) VALUES
(1, 'Ttitle', 'Sluug', '<p>Cntt</p>\r\n', 210, 1, '2018-02-05 15:31:28'),
(2, 'sa', 'aas', '<p>asaazsasa</p>\r\n\r\n<p>sasa</p>\r\n\r\n<p>sasa</p>\r\n\r\n<p><s><strong>sa</strong></s></p>\r\n', 210, 1, '2018-02-05 15:37:06'),
(3, 'This is a Job Analysis', 'job_analysis1.html', '<p>You can edit this default content on admin CMS page (<span class=\"marker\"><strong>default_job_analysis.html</strong></span>)</p>\r\n', 210, 0, '2018-02-08 17:17:52'),
(4, 'hgg', 'rhhh', '<p>? You can edit this default content on admin CMS page (default_job_analysis.html)</p>\r\n', 209, 0, '2018-02-06 04:10:06'),
(5, 'test', 'test', '<p>?</p>\n\n<p><big><strong>Demo NOTE:&nbsp;You can edit this default content on admin CMS page (default_job_analysis.html?</strong></big></p>\n\n<p><strong>Job Title: &nbsp; &nbsp; &nbsp;</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\n<strong>Classification: </strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\n<strong>Department/Division</strong>: &nbsp;<br />\n<strong>Location:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\n<strong>Pay Grade:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<p><strong>Job Requirements</strong></p>\n\n<p><em>EXAMPLE: </em></p>\n\n<ul>\n	<li>A. Summary of Position</li>\n</ul>\n\n<p><em>Researches and identifies target client sectors for financial product services. Develops and implements a sales process to include initial contact, follow up, presentation and closing procedures. Maintains records of contacts and sales status including contact reports, sales projections and quota ratios.</em></p>\n\n<p>&nbsp;</p>\n\n<ul>\n	<li>B. Job Duties<br />\n	<br />\n	&nbsp; &nbsp; 1) Research and Create targeted new client lists within Orange County California territory<br />\n	<br />\n	&nbsp; &nbsp; 2) Makes initial contact with potential clients<br />\n	<br />\n	&nbsp; &nbsp; 3) Performs routine and regular follow up with potential clients<br />\n	<br />\n	&nbsp; &nbsp; 4) Performs routine and regular follow up with former clients<br />\n	<br />\n	&nbsp; &nbsp; 5) Visits potential clients and makes sales presentations<br />\n	<br />\n	&nbsp; &nbsp; 6) Closes sales<br />\n	<br />\n	&nbsp; &nbsp; 7) Maintains regular record reporting sales activity<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>C. Computer Skills and Software Used<br />\n	<br />\n	&nbsp; &nbsp; 1) Windows operating system<br />\n	<br />\n	&nbsp; &nbsp; 2) MS Office including Word, Excel and PowerPoint<br />\n	<br />\n	&nbsp; &nbsp; 3) Constant Contact or other Customer Relations Management Software<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>D. Reporting Structure<br />\n	<br />\n	&nbsp; &nbsp; 1) Reports to regional sales manager<br />\n	<br />\n	&nbsp; &nbsp; 2) Has nobody directly reporting to this position<br />\n	<br />\n	&nbsp; &nbsp; 3) Required to participate in Annual Sales Meeting</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<p><strong>Employee Requirements</strong></p>\n\n<p><em>EXAMPLE: </em></p>\n\n<ul>\n	<li>A. Education and Training<br />\n	<br />\n	&nbsp; &nbsp; 1) Bachelor Degree in business, finance or accounting or 5 Years experience and High School Diploma. Bachelors Degree Preferred<br />\n	<br />\n	&nbsp; &nbsp; 2) ABC Financial Planning - Level 3 or higher (Fictional)<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>B. Skills and Aptitudes<br />\n	<br />\n	&nbsp; &nbsp; 1) Fearless cold caller, 250+ Outbound calls per week<br />\n	<br />\n	&nbsp; &nbsp; 2) Ability to close a sale<br />\n	<br />\n	&nbsp; &nbsp; 3. Adapt to changing financial conditions and meet customer expectations<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>C. Environment and Physical<br />\n	<br />\n	&nbsp; &nbsp; 1) Work in high volume sales office<br />\n	<br />\n	&nbsp; &nbsp; 2) Be able to sit for prolonged periods of time<br />\n	<br />\n	&nbsp; &nbsp; 3) Be able to travel to client locations 25% of time<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>D. Licenses/Certifications<br />\n	<br />\n	&nbsp; &nbsp; 1) CFP - Certified Financial Planner<br />\n	<br />\n	&nbsp; &nbsp; 2) California Drivers License<br />\n	&nbsp;</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<p><strong>Success Factors</strong></p>\n\n<p><em>EXAMPLE: </em></p>\n\n<ul>\n	<li>A. Grow Sales<br />\n	<br />\n	&nbsp; &nbsp; 1) Increase market channel penetration by 30% in first Year<br />\n	<br />\n	&nbsp; &nbsp; 2) Develop 3 secondary channels in first 180 days<br />\n	<br />\n	&nbsp; &nbsp; 3) Grow referral-based sales from 15% to 20% in first year<br />\n	<br />\n	&nbsp; &nbsp;&nbsp;</li>\n	<li>B. Develop Sales Department<br />\n	<br />\n	&nbsp; &nbsp; 1) Recruit and train 2 junior sales associates with gross sales of $500K by 3nd quarter<br />\n	<br />\n	&nbsp; &nbsp; 2) Increase number of sales presentations by 20% within 12 months<br />\n	<br />\n	&nbsp; &nbsp; 3) Implement Web-Meeting presentation System to Reduce travel costs by 20% per year</li>\n</ul>\n\n<p><br />\n<br />\nComments____________________________________________</p>\n\n<p>&nbsp;</p>\n\n<p>____________________________________________________</p>\n\n<p>____________________________________________________</p>\n\n<p><br />\n&nbsp;</p>\n\n<p>HR Representative___________________________________</p>\n\n<p>Department Manager__________________________________</p>\n\n<p>Date Completed______________________________________</p>\n', 209, 0, '2018-02-07 06:28:13'),
(6, '2', '3', '<p>?</p>\r\n\r\n<p><big><strong>Demo NOTE:&nbsp;You can edit this default content on admin CMS page (default_job_analysis.html?</strong></big></p>\r\n\r\n<p><strong>Job Title: &nbsp; &nbsp; &nbsp;</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n<strong>Classification: </strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n<strong>Department/Division</strong>: &nbsp;<br />\r\n<strong>Location:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\r\n<strong>Pay Grade:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Job Requirements</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Summary of Position</li>\r\n</ul>\r\n\r\n<p><em>Researches and identifies target client sectors for financial product services. Develops and implements a sales process to include initial contact, follow up, presentation and closing procedures. Maintains records of contacts and sales status including contact reports, sales projections and quota ratios.</em></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li>B. Job Duties<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Research and Create targeted new client lists within Orange County California territory<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Makes initial contact with potential clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Performs routine and regular follow up with potential clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 4) Performs routine and regular follow up with former clients<br />\r\n	<br />\r\n	&nbsp; &nbsp; 5) Visits potential clients and makes sales presentations<br />\r\n	<br />\r\n	&nbsp; &nbsp; 6) Closes sales<br />\r\n	<br />\r\n	&nbsp; &nbsp; 7) Maintains regular record reporting sales activity<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>C. Computer Skills and Software Used<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Windows operating system<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) MS Office including Word, Excel and PowerPoint<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Constant Contact or other Customer Relations Management Software<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>D. Reporting Structure<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Reports to regional sales manager<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Has nobody directly reporting to this position<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Required to participate in Annual Sales Meeting</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Employee Requirements</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Education and Training<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Bachelor Degree in business, finance or accounting or 5 Years experience and High School Diploma. Bachelors Degree Preferred<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) ABC Financial Planning - Level 3 or higher (Fictional)<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>B. Skills and Aptitudes<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Fearless cold caller, 250+ Outbound calls per week<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Ability to close a sale<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3. Adapt to changing financial conditions and meet customer expectations<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>C. Environment and Physical<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Work in high volume sales office<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Be able to sit for prolonged periods of time<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Be able to travel to client locations 25% of time<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>D. Licenses/Certifications<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) CFP - Certified Financial Planner<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) California Drivers License<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Success Factors</strong></p>\r\n\r\n<p><em>EXAMPLE: </em></p>\r\n\r\n<ul>\r\n	<li>A. Grow Sales<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Increase market channel penetration by 30% in first Year<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Develop 3 secondary channels in first 180 days<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Grow referral-based sales from 15% to 20% in first year<br />\r\n	<br />\r\n	&nbsp; &nbsp;&nbsp;</li>\r\n	<li>B. Develop Sales Department<br />\r\n	<br />\r\n	&nbsp; &nbsp; 1) Recruit and train 2 junior sales associates with gross sales of $500K by 3nd quarter<br />\r\n	<br />\r\n	&nbsp; &nbsp; 2) Increase number of sales presentations by 20% within 12 months<br />\r\n	<br />\r\n	&nbsp; &nbsp; 3) Implement Web-Meeting presentation System to Reduce travel costs by 20% per year</li>\r\n</ul>\r\n\r\n<p><br />\r\n<br />\r\nComments____________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>____________________________________________________</p>\r\n\r\n<p>____________________________________________________</p>\r\n\r\n<p><br />\r\n&nbsp;</p>\r\n\r\n<p>HR Representative___________________________________</p>\r\n\r\n<p>Department Manager__________________________________</p>\r\n\r\n<p>Date Completed______________________________________</p>\r\n', 210, 0, '2018-02-12 22:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_functional_areas`
--

CREATE TABLE `tbl_job_functional_areas` (
  `ID` int(7) NOT NULL,
  `industry_ID` int(7) DEFAULT NULL,
  `functional_area` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_industries`
--

CREATE TABLE `tbl_job_industries` (
  `ID` int(11) NOT NULL,
  `industry_name` varchar(155) DEFAULT NULL,
  `slug` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active',
  `top_category` enum('no','yes') DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

--
-- Dumping data for table `tbl_job_industries`
--

INSERT INTO `tbl_job_industries` (`ID`, `industry_name`, `slug`, `sts`, `top_category`) VALUES
(3, 'Accounts', 'accounts', 'active', 'yes'),
(5, 'Advertising', 'advertising', 'active', 'yes'),
(7, 'Banking', 'banking', 'active', 'yes'),
(10, 'Customer Service', 'customer-service', 'active', 'yes'),
(16, 'Graphic / Web Design', 'graphic-web-design', 'active', 'yes'),
(18, 'HR / Industrial Relations', 'hr-industrial-relations', 'active', 'yes'),
(22, 'IT - Software', 'it-software', 'active', 'yes'),
(35, 'Teaching / Education', 'teaching-education', 'active', 'yes'),
(40, 'IT - Hardware', 'it-hardware', 'active', 'yes'),
(42, 'Domstolsverket', 'domstolsverket', 'active', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_seekers`
--

CREATE TABLE `tbl_job_seekers` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `dated` datetime NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `gender` enum('female','male','other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `default_cv_id` int(11) NOT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `home_phone` varchar(25) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `career_objective` text,
  `sts` enum('active','blocked','pending') NOT NULL DEFAULT 'active',
  `verification_code` varchar(155) DEFAULT NULL,
  `first_login_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `slug` varchar(155) DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `queue_email_sts` tinyint(1) DEFAULT NULL,
  `send_job_alert` enum('no','yes') DEFAULT 'yes',
  `private` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_seekers`
--

INSERT INTO `tbl_job_seekers` (`ID`, `first_name`, `last_name`, `email`, `password`, `present_address`, `permanent_address`, `dated`, `country`, `city`, `gender`, `dob`, `phone`, `photo`, `default_cv_id`, `mobile`, `home_phone`, `cnic`, `nationality`, `channel`, `career_objective`, `sts`, `verification_code`, `first_login_date`, `last_login_date`, `slug`, `ip_address`, `old_id`, `flag`, `queue_email_sts`, `send_job_alert`, `private`) VALUES
(467, 'Testsep', '', 'CLICK2MAIL@gmail.com', '12345678', 'Storgatan 32A', NULL, '2018-09-04 06:36:19', 'Sverige', 'Solna', 'male', '1995-04-18', NULL, NULL, 0, '700775775', '', NULL, 'Sverige', 'Channel 1', NULL, 'active', '7443b08e746ef35417799e74987ab59f', NULL, NULL, NULL, '46.99.116.120', NULL, NULL, NULL, 'yes', 1),
(466, 'asdfasdf', NULL, 'ravinderpuri.waveinfotech.biz@gmail.com', '123456', 'asdfasdf', NULL, '2018-08-09 05:39:12', 'Sverige', 'asdf', 'male', '1982-10-16', NULL, 'asdfasdf-BiXma-466.jpg', 0, 'asdf', 'asdf', NULL, 'Sverige', 'Channel 1', NULL, 'active', '4f5ee53a018ee9f889c1fa8cfcb8bb16', NULL, NULL, NULL, '122.173.62.21', NULL, NULL, NULL, 'yes', 0),
(465, 'ramtannnn', '', 'EMAIL@gmail.com', 'test123', 'm;nbjkv', NULL, '2018-08-06 11:23:39', 'Sverige', 'ln', 'male', '1983-01-06', NULL, 'ramtannnn-BiXma-465.jpg', 0, '41548461', '', NULL, 'Sverige', 'Channel 1', NULL, 'active', '3c902ba4311741302525aa2eadbfd835', NULL, NULL, NULL, '85.224.186.245', NULL, NULL, NULL, 'yes', 1),
(11, 'Kganxx', '', 'kganxx@gmail.com', 'Solutions123', 'PO Box 450125', NULL, '2016-03-28 14:11:09', 'Sweden', 'Malmö', 'male', '1988-05-31', NULL, 'no-image.jpg', 0, '152485145', '', NULL, 'United Arab Emirates', NULL, NULL, 'active', '', '2016-03-28 14:13:41', '2016-03-28 14:13:41', NULL, '2.49.65.117', NULL, NULL, NULL, 'yes', 0),
(12, 'KAcykos', NULL, 'kacykos1@gmail.com', 'kacper93', 'adadad', NULL, '2016-03-28 14:46:29', 'Pakistan', 'Abu Dhabi', 'male', '1980-11-14', NULL, 'no-image.jpg', 0, '23242424', '', NULL, 'Australia', NULL, NULL, 'active', '', NULL, NULL, NULL, '83.27.161.159', NULL, NULL, NULL, 'yes', 0),
(13, 'ajay', NULL, 'jainmca4444@gmail.com', 'red@12321', 'ETS', NULL, '2016-03-28 17:40:38', 'Pakistan', 'Lahore', 'male', '1980-04-09', NULL, 'no-image.jpg', 0, '898989899', '', NULL, 'Australia', NULL, NULL, 'active', '', NULL, NULL, NULL, '112.196.142.218', NULL, NULL, NULL, 'yes', 0),
(14, 'Peter Sturm', NULL, 'petersturm@bluewin.ch', 'petertester', 'Via Cantone', NULL, '2016-03-28 18:18:22', 'United States', 'new york', 'male', '1980-01-01', NULL, 'no-image.jpg', 0, '678768768768', '', NULL, 'United States', NULL, NULL, 'active', '', NULL, NULL, NULL, '46.127.154.34', NULL, NULL, NULL, 'yes', 0),
(411, 'gfgfgfhh', NULL, 'hassanayoub85@hotmail.com', 'zaq12wsx', 'dsfdgfghhghgfh', NULL, '2018-01-25 09:49:27', 'Australia', 'fdfdf', 'male', '1984-05-01', NULL, NULL, 0, '0000000', '', NULL, 'Australia', NULL, NULL, 'active', '', NULL, NULL, NULL, '185.118.27.136', NULL, NULL, NULL, 'yes', 0),
(422, 'a', NULL, 'a@a.a', '123456', 'a', NULL, '2018-01-25 10:07:35', 'Australia', 'a', 'male', '1985-04-15', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, NULL, 'active', '', '2018-03-08 17:06:54', '2018-03-22 07:03:46', NULL, '41.142.0.106', NULL, NULL, NULL, 'yes', 0),
(423, 'Ram', '', 'mailramzi@gmail.com', 'test123', 'Sweden', NULL, '2018-01-25 10:27:02', 'Sweden', 'Linköping', 'male', '1979-02-27', NULL, NULL, 0, '0046700775775', '', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-25 10:31:27', '2018-01-29 15:03:31', NULL, '90.224.199.144', NULL, NULL, NULL, 'yes', 0),
(424, 'Ayoub Ezzini', '', 'a37killer@gmail.com', 'ayoub123', 'N/A', NULL, '2018-01-25 14:08:33', 'Sverige', 'Göteborg', 'male', '1997-09-06', NULL, 'ayoub-ezzini-BiXma-424.jpg', 0, '+212623357087', '', NULL, 'United Kingdom', NULL, NULL, 'active', '', '2018-01-27 08:39:44', '2018-09-07 14:52:07', NULL, '105.71.136.97', NULL, NULL, NULL, 'yes', 1),
(425, 'Kali Linux', '', 'ayoub.ezzini@gmail.com', '123456', 'Centralvägen 1, 171 68 Solna', NULL, '2018-01-26 06:02:03', 'Sweden', 'Eskilstuna', 'other', '1993-08-20', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, NULL, 'active', '', NULL, NULL, NULL, '105.156.230.57', NULL, NULL, NULL, 'yes', 0),
(426, 'Ramtaniii', '', 'ramzitanani@gmail.com', 'test123', 'Centralvägen 1, 171 68 Solna', 'ghjkl;', '2018-01-26 12:31:56', 'Sweden', 'Malmö', 'male', '1980-04-05', NULL, NULL, 0, '763356790', '', NULL, 'Australia', NULL, NULL, 'active', '', '2018-01-30 06:00:36', '2018-01-30 06:00:36', NULL, '90.224.199.144', NULL, NULL, NULL, 'yes', 0),
(428, 'Fredrik Öhrn', '', 'fredrik@ohrn.cc', 'qwerty', 'Vitoxelvägen 17', NULL, '2018-01-28 04:44:03', 'Sweden', 'Sydkoster', 'male', '1981-08-20', NULL, NULL, 0, '0703592426', '0703592426', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-28 05:16:31', '2018-01-28 05:16:31', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', 0),
(427, 'Tim S', '', 'sfi@travos.se', 'mimo123', 'Centralvägen 1', NULL, '2018-01-26 13:01:10', 'Sverige', 'Solna', 'male', '1976-10-04', NULL, 'tim-s-BiXma-427.png', 0, '0723189657', '0723189657', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-26 13:26:31', '2018-08-17 03:56:22', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', 1),
(429, 'Johan Gustafsson', NULL, 'timeo.skarander@dmediac.se', 'tim123', 'Finlandsgatan 52, 164 53 Kista', NULL, '2018-01-28 04:44:44', 'Sweden', 'KIsta', 'male', '1990-11-04', NULL, NULL, 0, '0723189657', '0046723189657', NULL, 'Australia', NULL, NULL, 'active', '', NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', 0),
(430, 'William Schwarz', '', 'schwarz@gmail.com', 'Pennor99', 'Lotsvägen 17', '', '2018-01-28 04:44:50', 'Sweden', '18166', 'male', '1996-12-20', NULL, 'william-schwarz-BiXma-430.png', 0, '+46735448155', '+46735448155', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-28 05:17:37', '2018-01-28 05:17:37', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', 0),
(431, 'a', NULL, 'admin@admin.com', 'aabb1234', 's', NULL, '2018-01-28 08:50:57', 'Sweden', 'k', 'male', '1980-09-16', NULL, NULL, 0, 'k', 'k', NULL, 'Swedish', NULL, NULL, 'active', '', NULL, NULL, NULL, '196.65.146.10', NULL, NULL, NULL, 'yes', 0),
(432, 'Demo', NULL, 'Demo@Demo.com', '123456', 'Demo', NULL, '2018-01-29 12:29:13', 'Sweden', 'Demo', 'male', '1977-03-04', NULL, NULL, 0, 'Demo', 'Demo', NULL, 'Swedish', NULL, NULL, 'active', '', NULL, NULL, NULL, '41.143.179.215', NULL, NULL, NULL, 'yes', 0),
(434, 'a', NULL, 'a3dkiller@gmail.com', 'ayoub123', 'a', NULL, '2018-01-29 15:05:51', 'Sweden', 'a', 'female', '1979-01-01', NULL, NULL, 0, 'a', 'a', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-30 08:26:58', '2018-01-30 08:26:58', NULL, '105.71.3.157', NULL, NULL, NULL, 'yes', 0),
(449, 'random', '', 'footballmood@gmail.com', 'test123', 'klhjgkfjhfg', NULL, '2018-01-30 06:18:59', 'Sverige', 'jfdr', 'other', '1980-03-17', NULL, 'random-BiXma-449.jpg', 0, '0046700775775', '', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-30 22:52:58', '2018-08-06 11:19:42', NULL, '85.225.194.156', NULL, NULL, NULL, 'yes', 1),
(439, 'a', NULL, 'ayoub.ezzin9@gmail.com', 'ayoub123', 'a', NULL, '2018-01-29 16:19:34', 'Sweden', 'a', 'male', '1980-01-01', NULL, NULL, 0, 'a', 'a', NULL, 'Swedish', NULL, NULL, 'active', '', NULL, NULL, NULL, '105.71.3.157', NULL, NULL, NULL, 'yes', 0),
(448, 'MOUHCIN AGOUJIL', '', 'mouhcin.agoujil@gmail.com', '123456', 'Kenitra', NULL, '2018-01-29 18:51:37', 'Sweden', 'Kenitra', 'male', '1980-03-03', NULL, NULL, 0, '660050553', '660050553', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-29 19:18:37', '2018-04-28 18:02:09', NULL, '105.157.116.186', NULL, NULL, NULL, 'yes', 0),
(450, 'Sara', NULL, 'sara.sundelinronquist@dom.se', 'Domstol', 'ldfmösg ag aåojg g  aåogj aåg  åo ga', NULL, '2018-01-30 08:12:50', 'Sweden', '55398', 'female', '1980-06-13', NULL, NULL, 0, '083726932939', '09394847', NULL, 'Swedish', NULL, NULL, 'active', '9e24c96570b32a24ebc63021edf11171', NULL, NULL, NULL, '159.190.240.1', NULL, NULL, NULL, 'yes', 0),
(451, 'William Schwarz', NULL, 'William.o.schwarz@gmail.com', 'Pennor99', 'Lotsvägen 17', NULL, '2018-01-30 08:12:51', 'Sweden', '18166', 'male', '1996-12-20', NULL, NULL, 0, '0735448155', '', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-30 08:38:29', '2018-01-30 09:56:56', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes', 0),
(452, 'David Schwarz', '', 'Harmonist.online@gmail.com', '1234567', 'Golfvägen 11', '', '2018-01-30 12:58:28', 'Sweden', '18129', 'male', '1984-12-20', NULL, 'david-schwarz-BiXma-452.png', 0, '+46735448155', '', NULL, 'Swedish', NULL, NULL, 'active', '65d834799c911cf5bf57153a03f24a28', NULL, NULL, NULL, '62.119.166.1', NULL, NULL, NULL, 'yes', 0),
(453, 'Maria', NULL, 'maria.fabricius@dom.se', 'domstol', 'dkföjfköas', NULL, '2018-01-30 13:34:18', 'Sweden', 'Jönköping', 'female', '1972-04-27', NULL, NULL, 0, '0789708', '', NULL, 'Swedish', NULL, NULL, 'active', 'b0367b630ffbdd58de9f55dac40b2875', NULL, NULL, NULL, '81.227.82.133', NULL, NULL, NULL, 'yes', 0),
(454, 'William Schwarz', '', 'Online.harmonist@gmail.com', 'Pennor99', 'Lotsvägen 17', NULL, '2018-01-30 15:32:13', 'Sweden', '18166', 'male', '1985-12-20', NULL, 'william-schwarz-BiXma-454.png', 0, '+46 735 44 5006', '', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-30 15:55:18', '2018-01-31 09:26:03', NULL, '212.214.188.54', NULL, NULL, NULL, 'yes', 0),
(455, 'Fly Flyerson', NULL, 'flyflyerson@gmail.com', 'Apple123', 'Street', NULL, '2018-03-02 00:55:15', 'Sverige', '12345', 'other', '1990-01-01', NULL, NULL, 0, '+14084066195', '', NULL, 'Sverige', NULL, NULL, 'active', '545f796b7043ead66627e281db04a8cb', NULL, NULL, NULL, '17.200.11.44', NULL, NULL, NULL, 'yes', 0),
(456, 'Demo user', '', 'a@a.com', 'a', 'Kenitra', NULL, '2018-01-29 18:51:37', 'Sverige', 'Stockholm', 'male', '1980-03-03', NULL, '', 0, '06 06 06 06 06', '05 05 05 05 05', NULL, 'Swedish', NULL, NULL, 'active', '', '2018-01-29 19:18:37', '2018-07-02 10:52:21', NULL, '105.157.116.186', NULL, NULL, NULL, 'yes', 1),
(457, 'Arabimosta', NULL, 'arabi123@gmail.com', 'arabi123', 'Fes fes', NULL, '2018-03-21 17:57:08', 'Sverige', 'Fes', 'male', '1980-08-08', NULL, NULL, 0, '0674388739', '0674388739', NULL, 'Sverige', NULL, NULL, 'active', 'dcf5c3aba76853dcf62839ad91e89271', NULL, NULL, NULL, '105.144.208.170', NULL, NULL, NULL, 'yes', 0),
(458, 'iLSDUKG', NULL, 'jareedah@gmail.com', 'test123', ';dsluvydxl;\'', NULL, '2018-05-12 13:15:08', 'Sverige', '', 'male', '1995-05-04', NULL, NULL, 0, '2453653', '', NULL, 'Sverige', 'Channel 1', NULL, 'active', '98290fad855216d7f29bdafdae1a96bf', NULL, NULL, NULL, '85.225.194.123', NULL, NULL, NULL, 'yes', 0),
(459, '', NULL, 'ddd@gmail.com', '123456', '', NULL, '2018-05-12 14:55:54', 'Sverige', '', 'male', '0000-00-00', NULL, NULL, 0, '', '', NULL, 'Sverige', 'Channel 1', NULL, 'active', 'a64c43e51013c681a2b476366082e7c0', NULL, NULL, NULL, '105.158.171.98', NULL, NULL, NULL, 'yes', 0),
(461, 'TEST', NULL, 'test@bixma.com', 'test123', '', NULL, '2018-05-20 10:01:35', 'Sverige', '', 'male', '0000-00-00', NULL, NULL, 0, '', '', NULL, 'Sverige', NULL, NULL, 'active', 'cb71f03a3292fdd23a4c481d5f844861', NULL, NULL, NULL, '160.178.214.88', NULL, NULL, NULL, 'yes', 0),
(462, 'Frida Vastamäki', '', 'frida@travos.se', 'travos', 'Bergvägen 6A', NULL, '2018-05-21 08:07:17', 'Sverige', 'Enebyberg', 'female', '1994-07-04', NULL, 'frida-vastamki-BiXma-462.jpg', 0, '072090898', '', NULL, 'Sverige', NULL, NULL, 'active', '', '2018-05-21 08:23:03', '2018-09-11 04:31:32', NULL, '79.142.247.190', NULL, NULL, NULL, 'yes', 1),
(463, 'Agoujil mohcin', NULL, 'mohcin@agoujil.com', '123456', '', NULL, '2018-05-21 09:34:49', 'Sverige', '', 'male', '0000-00-00', NULL, NULL, 0, '', '', NULL, 'Sverige', NULL, NULL, 'active', '8df94f0a62a7f3aa86294e5913acf8bd', NULL, NULL, NULL, '160.176.82.72', NULL, NULL, NULL, 'yes', 0),
(464, 'Olof Grahn', NULL, 'Olofgrahn@gmail.com', 'fredrik187', '', NULL, '2018-05-22 03:52:16', 'Sverige', '', 'male', '1960-09-19', NULL, NULL, 0, '0733838999', '', NULL, 'Sverige', 'Channel 1', NULL, 'active', '4fcba4d9fe7bf6c9d9a20abc9a0b9916', NULL, NULL, NULL, '78.78.3.127', NULL, NULL, NULL, 'yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_titles`
--

CREATE TABLE `tbl_job_titles` (
  `ID` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_titles`
--

INSERT INTO `tbl_job_titles` (`ID`, `value`, `text`) VALUES
(1, 'Web Designer', 'Web Designer'),
(2, 'Web Developer', 'Web Developer'),
(3, 'Graphic Designer', 'Graphic Designer'),
(4, 'Project Manager', 'Project Manager'),
(5, 'Network Administrator', 'Network Administrator'),
(6, 'Network Engineer', 'Network Engineer'),
(7, 'Software Engineer', 'Software Engineer'),
(8, 'System Administrator', 'System Administrator'),
(9, 'System Analyst', 'System Analyst');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_labels`
--

CREATE TABLE `tbl_labels` (
  `ID` int(11) NOT NULL,
  `label` text,
  `description` text,
  `company_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_labels`
--

INSERT INTO `tbl_labels` (`ID`, `label`, `description`, `company_id`, `deleted`, `created_at`) VALUES
(1, 'labelk23', NULL, 210, 1, '2018-02-03 06:35:35'),
(2, 'sasa2', NULL, 210, 1, '2018-02-03 06:35:52'),
(3, 'sasa', 'ss', 210, 0, '2018-02-03 15:20:46'),
(4, 'Hi', 'Desc2', 210, 0, '2018-02-03 15:23:06'),
(5, 'Candidates', 'For future', 209, 1, '2018-02-04 15:32:57'),
(6, 'Tim', 'Jobb', 211, 1, '2018-02-04 15:37:59'),
(7, 'Test', 'Test', 209, 1, '2018-02-04 15:36:43'),
(8, 'Test2', 'Uhfsgh', 209, 1, '2018-02-04 15:34:34'),
(9, 'Theater ', 'Theater', 211, 0, '2018-02-04 15:42:01'),
(10, 'LA', 'LA', 209, 0, '2018-04-22 09:48:05'),
(11, 'LZ', 'la', 209, 0, '2018-04-22 09:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_labels_dtl`
--

CREATE TABLE `tbl_labels_dtl` (
  `ID` int(11) NOT NULL,
  `label_id` int(11) DEFAULT NULL,
  `fk_id` varchar(255) DEFAULT NULL,
  `fk_type` varchar(20) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_labels_dtl`
--

INSERT INTO `tbl_labels_dtl` (`ID`, `label_id`, `fk_id`, `fk_type`, `deleted`, `created_at`) VALUES
(5, 3, '115', 'post_jobs', 1, '2018-02-04 11:10:14'),
(6, 4, '454', 'job_seekers', 0, '2018-02-04 11:57:09'),
(8, 5, '140', 'post_jobs', 0, '2018-02-04 15:16:20'),
(9, 5, '137', 'post_jobs', 0, '2018-02-04 15:27:38'),
(10, 3, '116', 'post_jobs', 1, '2018-02-04 16:12:23'),
(11, 4, '116', 'post_jobs', 1, '2018-02-04 16:22:24'),
(12, 4, '116', 'post_jobs', 1, '2018-02-04 16:25:17'),
(13, 10, '155', 'post_jobs', 0, '2018-09-14 11:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lang`
--

CREATE TABLE `tbl_lang` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Abbreviation` varchar(10) DEFAULT NULL,
  `rtl` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lang`
--

INSERT INTO `tbl_lang` (`ID`, `Name`, `Abbreviation`, `rtl`, `created_at`) VALUES
(6, 'Svenska', 'SV', 'ltr', NULL),
(7, 'Arabiska', 'AR', 'rtl', NULL),
(9, 'Spanska', 'ES', 'ltr', NULL),
(10, 'Franska', 'FR', 'ltr', NULL),
(12, 'Somaliska', 'SO', 'ltr', NULL),
(17, 'Persiska', 'FA', 'rtl', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newsletter`
--

CREATE TABLE `tbl_newsletter` (
  `ID` int(11) NOT NULL,
  `email_name` varchar(50) DEFAULT NULL,
  `from_name` varchar(60) DEFAULT NULL,
  `from_email` varchar(120) DEFAULT NULL,
  `email_subject` varchar(100) DEFAULT NULL,
  `email_body` text,
  `email_interval` int(4) DEFAULT NULL,
  `status` enum('inactive','active') DEFAULT 'active',
  `dated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_jobs`
--

CREATE TABLE `tbl_post_jobs` (
  `ID` int(11) NOT NULL,
  `employer_ID` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_ID` int(11) NOT NULL,
  `industry_ID` int(11) NOT NULL,
  `pay` varchar(60) NOT NULL,
  `dated` date NOT NULL,
  `sts` enum('inactive','pending','blocked','active','archive') NOT NULL DEFAULT 'pending',
  `is_featured` enum('no','yes') NOT NULL DEFAULT 'no',
  `country` varchar(100) NOT NULL,
  `last_date` date NOT NULL,
  `age_required` varchar(50) NOT NULL,
  `qualification` varchar(60) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `job_mode` enum('Home Based','Part Time','Full Time') NOT NULL DEFAULT 'Full Time',
  `vacancies` int(3) NOT NULL,
  `job_description` longtext NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(30) NOT NULL,
  `viewer_count` int(11) NOT NULL DEFAULT '0',
  `job_slug` varchar(255) DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `required_skills` varchar(255) DEFAULT NULL,
  `email_queued` tinyint(1) DEFAULT '0',
  `diarie` text,
  `job_type` varchar(255) DEFAULT NULL,
  `local_mdp` varchar(255) DEFAULT NULL,
  `quizz_text` text,
  `answer_1` varchar(255) DEFAULT NULL,
  `answer_2` varchar(255) DEFAULT NULL,
  `answer_3` varchar(255) DEFAULT NULL,
  `advertise` text,
  `job_analysis_id` int(11) NOT NULL,
  `interview_id` int(11) NOT NULL,
  `employer_certificate_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_post_jobs`
--

INSERT INTO `tbl_post_jobs` (`ID`, `employer_ID`, `job_title`, `company_ID`, `industry_ID`, `pay`, `dated`, `sts`, `is_featured`, `country`, `last_date`, `age_required`, `qualification`, `experience`, `city`, `job_mode`, `vacancies`, `job_description`, `contact_person`, `contact_email`, `contact_phone`, `viewer_count`, `job_slug`, `ip_address`, `flag`, `old_id`, `required_skills`, `email_queued`, `diarie`, `job_type`, `local_mdp`, `quizz_text`, `answer_1`, `answer_2`, `answer_3`, `advertise`, `job_analysis_id`, `interview_id`, `employer_certificate_id`, `deleted`, `note`) VALUES
(1, 1, 'Web Designer', 1, 22, '81000-100000', '2016-03-11', 'blocked', 'yes', 'United States', '2016-07-11', '', 'BA', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex.', '', '', '', 0, 'mega-technologies-jobs-in-new york-web-designer-1', '115.186.165.234', NULL, NULL, 'css, html, js, jquery', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(2, 1, 'Php Developer', 1, 22, '41000-50000', '2016-03-11', 'blocked', 'yes', 'United States', '2018-01-11', '', 'MA', '3', 'New York', 'Full Time', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex.', '', '', '', 0, 'mega-technologies-jobs-in-new york-php-developer-2', '115.186.165.234', NULL, NULL, 'php, js, jquery, html', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(3, 2, 'Java Developer', 2, 22, '16000-20000', '2016-03-11', 'blocked', 'yes', 'United States', '2016-07-11', '', 'BA', '2', 'New York', 'Part Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in. Nulla at viverra metus, id porttitor nulla. In et arcu id felis eleifend auctor vitae a justo. Nullam eleifend, purus id hendrerit tempus, massa elit vehicula metus, pharetra elementum lectus elit ac felis. Sed fermentum luctus aliquet. Vestibulum pulvinar ornare ipsum, gravida condimentum nulla luctus sit amet. Sed tempor eros a tempor faucibus. Proin orci tortor, placerat sit amet elementum sit amet, ornare vel urna.', '', '', '', 0, 'it-pixels-jobs-in-new york-java-developer-3', '115.186.165.234', NULL, NULL, 'js, php, html, css', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(4, 3, 'Dot Net Developer', 3, 22, '61000-70000', '2016-03-11', 'blocked', 'yes', 'Australia', '2016-07-11', '', 'Certification', '4', 'Sydney', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'info-technologies-jobs-in-sydney-dot-net-developer-4', '115.186.165.234', NULL, NULL, '.net, mysql, php, html, css', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(5, 4, 'Front End Developer', 4, 22, '61000-70000', '2016-03-11', 'blocked', 'no', 'China', '2016-07-11', '', 'BS', 'Fresh', 'Hong Kong', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'some-it-company-jobs-in-hong kong-front-end-developer-5', '115.186.165.234', NULL, NULL, 'html, css, js, jquery, owl, photoshop', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(6, 5, 'Head Of Digital Marketing', 5, 5, '21000-25000', '2016-03-11', 'blocked', 'no', 'United Arab Emirates', '2016-07-11', '', 'MS', 'Fresh', 'Dubai', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'abc-it-tech-jobs-in-dubai-head-of-digital-marketing-6', '101.50.114.8', NULL, NULL, 'html, seo, social media', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(7, 6, 'Graphic Designer Adobe Indesign Expert', 6, 22, 'Trainee Stipend', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'BS', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'def-it-company-jobs-in-new york-graphic-designer-adobe-indesign-expert-7', '101.50.114.8', NULL, NULL, 'photoshop, illustrator, indesign, css, html', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(8, 7, 'Teachers And Administration Staff', 7, 5, '41000-50000', '2016-03-11', 'blocked', 'yes', 'United Arab Emirates', '2016-07-11', '', 'Certification', '3', 'Dubai', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'ghi-company-jobs-in-dubai-teachers-and-administration-staff-8', '101.50.114.8', NULL, NULL, 'marketing', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(9, 8, 'Graphic Designer', 8, 22, '36000-40000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'Diploma', '1', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'jkl-company-jobs-in-new york-graphic-designer-9', '101.50.114.8', NULL, NULL, 'photoshop, illustrator, indesign, html, css', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(10, 9, 'Front End Developers', 9, 22, '61000-70000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'Certification', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mno-company-jobs-in-new york-front-end-developers-10', '101.50.114.8', NULL, NULL, 'html, css, jquery, js', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(11, 10, 'Seo Specialist', 10, 5, '36000-40000', '2016-03-11', 'blocked', 'no', 'Pakistan', '2016-07-11', '', 'BE', '4', 'Islamabad', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mnt-comapny-jobs-in-islamabad-seo-specialist-11', '101.50.114.8', NULL, NULL, 'seo, sem, smm, google adward', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(12, 11, 'Web Design / Frontend Developer', 11, 16, '51000-60000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'BA', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mnf-comapny-jobs-in-new york-web-design-frontend-developer-12', '101.50.114.8', NULL, NULL, 'html, css, photoshop, illustrator, js', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(13, 12, 'Account Officer', 12, 18, '41000-50000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'MS', 'Fresh', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'qwe-company-jobs-in-new york-account-officer-13', '115.186.165.234', NULL, NULL, 'accounting, marketing, ms office', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(14, 13, 'Call Center Operator', 13, 10, '51000-60000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'Certification', '4', 'Los Angeles', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'asd-company-jobs-in-los angeles-call-center-operator-14', '115.186.165.234', NULL, NULL, 'marketting, ms office, mysql', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(15, 14, 'Hr Specilest', 14, 18, '51000-60000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'MBA', '3', 'Las Vegas', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'xcv-company-jobs-in-las vegas-hr-specilest-15', '115.186.165.234', NULL, NULL, 'ms office, html, css, mysql', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(114, 209, 'Developer', 209, 22, 'Depends', '2018-01-25', 'blocked', 'yes', 'Sweden', '2018-01-31', '', 'MS', 'Fresh', 'Stockholm', 'Full Time', 1, 'This&nbsp;is a&nbsp;job&nbsp;post&nbsp;test by&nbsp;bixma.', 'Ramzi', 'bixmatech@gmail.com', '0046700775775', 0, 'bixma-jobs-in-stockholm-developer-114', '90.224.199.144', NULL, NULL, 'word', 0, NULL, NULL, NULL, 'Who are we?', 'Bixma', 'Bima', 'Bixa', '        <div style=\'width: 750px;max-width: 750px; margin: auto;\' id=\'canvas\'>\r\n        <div class=\'companyinfoWrp\'>\r\n\r\n        <h1 class=\'jobname\'>Developer</h1>\r\n        <div class=\'jobthumb\'><img src=\'http://vps47202.lws-hosting.com/public/uploads/employer/JOBPORTAL-1516898144.png\' /></div>\r\n        <div class=\'jobloc\'><h3>Bixma</h3>\r\n        </div>\r\n        <div class=\'clear\'></div>\r\n        </div>\r\n        </div>\r\n        ', 0, 0, 0, 0, ''),
(115, 210, 'Laravel Developer', 210, 22, '350000-450000', '2018-01-25', 'inactive', 'yes', 'Sverige', '2018-05-25', '', 'CA', 'Fresh', 'N.A', 'Full Time', 1, '<p>We need a Laravel d<strong>eve</strong>loper.</p>', 'e', 'e', 'e', 0, 'travos-ab-jobs-in-n.a-laravel-developer-115', '105.71.136.97', NULL, NULL, 'php, laravel', 0, '', 'Local', '', '', '', '', '', NULL, 0, 0, 0, 0, ''),
(116, 210, 'Lärare', 210, 35, 'Trainee Stipend', '2018-01-25', 'inactive', 'yes', 'Sverige', '2018-05-25', '', 'MBA', 'Fresh', 'N.A', 'Full Time', 1, '<h1>hu&nbsp; <a href=\"http://google.com\">dz</a>dzda&nbsp;zdzadz<strong>a zad&nbsp; zaza&nbsp;<s>dzd</s></strong></h1>', 'sa', 'asa', 'as', 0, 'travos-ab-jobs-in-n.a-lrare-116', '158.174.4.45', NULL, NULL, 'asa', 0, 'sasa2', 'Internal', 'TEST', '2,3', 's', 's', '', NULL, 3, 6, 7, 0, 'ss2'),
(144, 209, 'Developer', 209, 22, 'Trainee Stipend', '2018-02-07', 'blocked', 'no', 'Sverige', '2018-06-07', '', 'CA', 'Fresh', 'Kenitra', 'Full Time', 1, '<p>kljukyftx</p>', 'Demo', 'demo', '660050553', 0, 'bixma-jobs-in-kenitra-developer-144', '85.225.194.156', NULL, NULL, 'word', 0, '', NULL, NULL, '', '', '', '', NULL, 5, 0, 0, 0, 'Notera'),
(117, 216, 'Advokat', 216, 42, '26000-30000', '2018-01-26', 'blocked', 'yes', 'Sweden', '2018-05-26', '', 'BA', 'Fresh', 'Malmö', 'Part Time', 10, '&Auml;r du nyexaminerad advokat och &auml;r nyfiken p&aring; ett arbete i allm&auml;n f&ouml;rvaltningsdomstol innan du forts&auml;tter din yrkeskarri&auml;r? Arbetet p&aring;minner i stora delar om arbetet som f&ouml;redragande jurist, vilket &auml;r ett arbete som i regel endast erfarna jurister kommer i fr&aring;ga f&ouml;r. Arbetet som f&ouml;redragande jurist &auml;r ett kvalificerat juristarbete som best&aring;r i att bereda m&aring;l, g&ouml;ra r&auml;ttsutredningar, f&ouml;redra m&aring;l f&ouml;r avg&ouml;rande, vara protokollf&ouml;rare vid muntliga f&ouml;rhandlingar samt att utarbeta f&ouml;rslag till domar eller beslut. Som jurist inom migrationsr&auml;tt ges du m&ouml;jlighet att arbeta under handledning av v&aring;ra mentorer.<br />\r\nKvalifikationer<br />\r\nF&ouml;r att komma i fr&aring;ga f&ouml;r tj&auml;nsten ska du nyligen ha tagit din juristexamen och bifoga ditt examensbevis, max 1 sida, i din ans&ouml;kan.<br />\r\nVi ser g&auml;rna att du har utbildning och/eller erfarenhet inom migrationsr&auml;tt.<br />\r\nDu &auml;r en noggrann person som har f&ouml;rm&aring;ga att strukturera och planera ditt arbete. Du kan organisera och prioritera olika arbetsuppgifter. Du uttrycker dig v&auml;l i b&aring;de tal och skrift. Du kan arbeta sj&auml;lvst&auml;ndigt men har ocks&aring; l&auml;tt f&ouml;r att samarbeta och arbeta i grupp.<br />\r\nVi f&auml;ster stor vikt vid personliga egenskaper och d&auml;rf&ouml;r kommer testning att vara en del av rekryteringsprocessen.', '', '', '', 0, 'malm-tingsrtt-jobs-in-malmö-advokat-117', '83.183.12.57', NULL, NULL, 'advokat', 0, NULL, NULL, NULL, '', 'advokat', '', '', NULL, 0, 0, 0, 0, ''),
(118, 213, 'Advokat', 213, 42, '31000-35000', '2018-01-27', 'blocked', 'no', 'Sweden', '2018-02-28', '', 'BA', 'Fresh', 'Jönköping', 'Part Time', 10, 'advokat, word', '', '', '', 0, 'jnkpings-tingsrtt-jobs-in-jönköping-advokat-118', '2.65.17.62', NULL, NULL, 'advokat, word', 0, NULL, NULL, NULL, '', 'advokat', '', '', NULL, 0, 0, 0, 0, ''),
(119, 215, 'Administratör  - Eskilstuna', 215, 42, '21000-25000', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-05-31', '', 'MBA', '2', 'Eskilstuna', 'Part Time', 2, 'Hej! Eskilstuna tingsr&auml;tt har nu en ledig position som administrat&ouml;r p&aring; deltid.&nbsp;', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-administratr-eskilstuna-119', '83.183.12.57', NULL, NULL, 'excel , administratör', 0, NULL, NULL, NULL, 'har du en universitets examen? ', '', '', '', NULL, 0, 0, 0, 0, ''),
(120, 213, 'Jurist', 213, 42, '26000-30000', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-03-29', '', 'BA', '2', 'Jönköping', 'Full Time', 1, 'Dokumenterade erafrenheter.<br />\r\nIntyg kr&auml;vs.', '', '', '', 0, 'jnkpings-tingsrtt-jobs-in-jönköping-jurist-120', '83.183.12.57', NULL, NULL, 'jurist, word, engelska', 0, NULL, NULL, NULL, '', 'Jurist?', 'Word', '', NULL, 0, 0, 0, 0, ''),
(121, 211, '2 Kvalificerade åklagare Sökes', 211, 42, '26000-30000', '2018-01-28', 'blocked', 'yes', 'Sweden', '2018-06-14', '', 'PhD', '3', 'Sollentuna', 'Full Time', 2, 'Vi s&ouml;ker 2 &aring;klagare till Attunda tingsr&auml;tt', '', '', '', 0, 'attunda-tingsrtt-jobs-in-sollentuna-2-kvalificerade-klagare-skes-121', '83.183.12.57', NULL, NULL, 'jurist, entreprenör', 0, NULL, NULL, NULL, 'Är du behörig åklagare', 'Ja', 'Nej', 'Blivande', NULL, 0, 0, 0, 0, ''),
(125, 209, 'Jbv', 209, 5, 'Trainee Stipend', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-05-28', '', 'CA', 'Fresh', 'Stockholm', 'Full Time', 1, '.nb', '', '', '', 0, 'bixma-jobs-in-stockholm-jbv-125', '2.64.193.56', NULL, NULL, 'word', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(126, 209, 'Jbv', 209, 5, 'Trainee Stipend', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-05-28', '', 'CA', 'Fresh', 'Stockholm', 'Full Time', 1, '.nb', '', '', '', 0, 'bixma-jobs-in-stockholm-jbv-126', '2.64.193.56', NULL, NULL, 'word', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(127, 209, 'Jbv', 209, 5, 'Trainee Stipend', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-05-28', '', 'CA', 'Fresh', 'Stockholm', 'Full Time', 1, '.nbhgouhi<br />\r\n<br />\r\nhvjl&#39;<br />\r\n<br />\r\nchvjhkjl', '', '', '', 0, 'bixma-jobs-in-stockholm-jbv-127', '2.64.193.56', NULL, NULL, 'word', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(128, 209, 'Jbv', 209, 5, 'Trainee Stipend', '2018-01-28', 'blocked', 'no', 'Sweden', '2018-05-28', '', 'CA', 'Fresh', 'Stockholm', 'Full Time', 1, '.nbhgouhi<br />\r\n<br />\r\nhvjl&#39;<br />\r\n<br />\r\nchvjhkjl', 'Trt', 'bixmatech@gmail.com', '3576322', 0, 'bixma-jobs-in-stockholm-jbv-128', '2.64.193.56', NULL, NULL, 'word, php', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(129, 209, '#ref278 Test Job With Reference', 209, 7, 'Trainee Stipend', '2018-01-30', 'archive', 'no', 'Sweden', '2018-05-30', '', 'Certification', 'Fresh', 'Stockholm', 'Full Time', 1, '<p>jbhgc</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-ref278-test-job-with-reference-129', '90.224.199.144', NULL, NULL, 'word', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(130, 215, 'Jurist', 215, 42, '21000-25000', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'PhD', '2', 'Eskilstuna', 'Full Time', 1, '<p>Hej! Nu s&ouml;ker vi Jurister p&aring; Domstolsverket!</p>', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-jurist-130', '2.68.57.71', NULL, NULL, 'jurist, excell', 0, NULL, NULL, NULL, 'Har du examens bevis?', 'Ja', 'Nej', 'Pågående utbildning ', NULL, 0, 0, 0, 0, ''),
(131, 215, 'Jurist', 215, 42, '21000-25000', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'PhD', '2', 'Eskilstuna', 'Full Time', 1, '<p>Hej! Nu s&ouml;ker vi Jurister p&aring; Domstolsverket!</p>', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-jurist-131', '2.68.57.71', NULL, NULL, 'excell, jurist', 0, NULL, NULL, NULL, 'Har du examens bevis?', 'Ja', 'Nej', 'Pågående utbildning ', NULL, 0, 0, 0, 0, ''),
(132, 215, 'Jurist', 215, 42, '21000-25000', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'PhD', '2', 'Eskilstuna', 'Full Time', 1, '<p>Hej! Nu s&ouml;ker vi Jurister p&aring; Domstolsverket!</p>', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-jurist-132', '2.68.57.71', NULL, NULL, 'excell', 0, NULL, NULL, NULL, 'Har du examens bevis?', 'Ja', 'Nej', 'Pågående utbildning ', NULL, 0, 0, 0, 0, ''),
(133, 215, 'Jurist', 215, 42, '21000-25000', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'PhD', '2', 'Eskilstuna', 'Full Time', 1, '<p>Hej! Nu s&ouml;ker vi Jurister p&aring; Domstolsverket!</p>', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-jurist-133', '2.68.57.71', NULL, NULL, 'excell', 0, NULL, NULL, NULL, 'Har du examens bevis?', 'Ja', 'Nej', 'Pågående utbildning ', NULL, 0, 0, 0, 0, ''),
(134, 211, 'Hr-specialist', 211, 42, 'Discuss', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-03-07', '', 'B.Tech', '2', 'Jönköping', 'Full Time', 1, '<p>Testannons</p>\r\n\r\n<p>H&auml;r provar jag n&aring;gra olika typsnitt</p>', '', '', '', 0, 'attunda-tingsrtt-jobs-in-jönköping-hrspecialist-134', '81.227.82.133', NULL, NULL, 'hr, administration', 0, NULL, NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(135, 211, 'Hr-specialist', 211, 42, 'Discuss', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-03-07', '', 'B.Tech', '2', 'Jönköping', 'Full Time', 1, '<p>Testannons</p>\r\n\r\n<p>H&auml;r provar jag n&aring;gra olika typsnitt</p>', '', '', '', 0, 'attunda-tingsrtt-jobs-in-jönköping-hrspecialist-135', '81.227.82.133', NULL, NULL, 'hr, administration', 0, NULL, NULL, NULL, '', '<div style=', '<div style=', '<div style=', NULL, 0, 0, 0, 0, ''),
(136, 211, 'Rekryterare', 211, 18, '21000-25000', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-31', '', 'BA', '2', 'Attunda', 'Part Time', 1, '<p>Nu s&ouml;ker vi en rekryterare p&aring; heltid.</p>\r\n\r\n<p>Vill du arbeta i en omv&auml;xlande milj&ouml; med m&aring;nga bollar i luften &auml;r det h&auml;r r&auml;tt arbete f&ouml;r dig!</p>\r\n\r\n<p>Vi ser g&auml;rna att du tidigare har arbetat inom HR och rekrytering.</p>', '', '', '', 0, 'attunda-tingsrtt-jobs-in-attunda-rekryterare-136', '212.214.188.54', NULL, NULL, 'excell, administration, rekrytering', 0, '12345', NULL, NULL, '2,3', 'ja', 'nej', 'Praktiserat', NULL, 0, 0, 0, 0, ''),
(137, 209, 'New Job Post Design', 209, 5, 'Trainee Stipend', '2018-01-30', 'archive', 'no', 'Sweden', '2018-05-30', '', 'BS', 'Fresh', 'Stockholm', 'Full Time', 1, '<p><a href=\"https://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\"><img alt=\"\" src=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\" style=\"height:400px; width:698px\" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>New job wit design here you go. You can add pictures to job post. <strong>You can bold it,</strong> write italic, or&nbsp;<a href=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\">hyperlink</a></p>\r\n\r\n<p>Let&#39;s add a table...</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>lkn</td>\r\n			<td>mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>n,,jb</td>\r\n			<td>kkn;n</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<ul>\r\n	<li>bullets</li>\r\n	<li>bullets</li>\r\n</ul>\r\n\r\n<ol>\r\n	<li>And more</li>\r\n	<li>Test it</li>\r\n</ol>', '', '', '', 0, 'bixma-jobs-in-stockholm-new-job-post-design-137', '85.225.194.156', NULL, NULL, 'art', 0, 'REF 270', NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(138, 209, 'New Job Post Design', 209, 5, 'Trainee Stipend', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'BS', 'Fresh', 'Stockholm', 'Full Time', 1, '<p><a href=\"https://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\"><img alt=\"\" src=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\" style=\"height:400px; width:698px\" /></a></p>\r\n\r\n<p>New job wit design here you go. You can add pictures to job post. <strong>You can bold it,</strong> write italic, or&nbsp;<a href=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\">hyperlink</a></p>\r\n\r\n<p>Let&#39;s add a table...</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>lkn</td>\r\n			<td>mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>n,,jb</td>\r\n			<td>kkn;n</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<ul>\r\n	<li>bullets</li>\r\n	<li>bullets</li>\r\n</ul>\r\n\r\n<ol>\r\n	<li>And more</li>\r\n	<li>Test it</li>\r\n</ol>', '', '', '', 0, 'bixma-jobs-in-stockholm-new-job-post-design-138', '85.225.194.156', NULL, NULL, 'art', 0, 'REF 270', NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(139, 209, 'New Job Post Design', 209, 5, 'Trainee Stipend', '2018-01-30', 'blocked', 'no', 'Sweden', '2018-05-30', '', 'BS', 'Fresh', 'Stockholm', 'Full Time', 1, '<p><a href=\"https://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\"><img alt=\"\" src=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\" style=\"height:400px; width:698px\" /></a></p>\r\n\r\n<p>New job wit design here you go. You can add pictures to job post. <strong>You can bold it,</strong> write italic, or&nbsp;<a href=\"http://media-exp2.licdn.com/mpr/mpr/AAEAAQAAAAAAAAiyAAAAJDEzM2ZhNzUyLTA1MWYtNDhmZC05MGQ5LWMyZjVlZWIyYTdmOA.jpg\">hyperlink</a></p>\r\n\r\n<p>Let&#39;s add a table...</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>lkn</td>\r\n			<td>mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>n,,jb</td>\r\n			<td>kkn;n</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<ul>\r\n	<li>bullets</li>\r\n	<li>bullets</li>\r\n</ul>\r\n\r\n<ol>\r\n	<li>And more</li>\r\n	<li>Test it</li>\r\n</ol>', '', '', '', 0, 'bixma-jobs-in-stockholm-new-job-post-design-139', '85.225.194.156', NULL, NULL, 'illustrator', 0, 'REF 270', NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(140, 209, 'Test2', 209, 16, 'Trainee Stipend', '2018-01-30', 'archive', 'no', 'Sweden', '2018-05-30', '', 'BA', 'Fresh', 'Stockholm', 'Full Time', 1, '<p>kdwqub</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>jkbdwq</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>klbjkdh</p>\r\n\r\n<p>ljbqwd</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-test2-140', '85.225.194.156', NULL, NULL, 'word', 0, 'ref07', NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(141, 209, 'Test Test Test', 209, 7, 'Trainee Stipend', '2018-01-30', 'archive', 'no', 'Sweden', '2018-05-30', '', 'CA', 'Fresh', 'Stockholm', 'Full Time', 1, '<p>Supervisors: kjju&nbsp; &nbsp; &nbsp; and&nbsp; &nbsp; &nbsp;skijhf</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<hr />\r\n<p><strong>Job description:</strong></p>\r\n\r\n<p>ngninoin onionunu nbouuiub bubuibui buibuibui&nbsp;</p>\r\n\r\n<p>h h bh hjj.</p>\r\n\r\n<hr />\r\n<p><strong>Main roles:</strong></p>\r\n\r\n<p>hbUIUI HUIHUHUI UIIBIYGB BIBUIB&nbsp;</p>\r\n\r\n<p>YVYUVUYVYUVUY UVUYVUYV&nbsp;</p>\r\n\r\n<hr />\r\n<p>ETC ETC ETC...</p>', 'BIXMAtech', 'bixmatech@gmail.com', '0183690738', 0, 'bixma-jobs-in-stockholm-test-test-test-141', '85.225.194.156', NULL, NULL, 'word', 0, '', NULL, NULL, '', '', '', '', NULL, 0, 0, 0, 0, ''),
(142, 211, 'A', 211, 10, 'Trainee Stipend', '2018-01-31', 'blocked', 'no', 'Sweden', '2018-05-31', '', 'Certification', '1', 'Sollentuna', 'Full Time', 1, '<p>aa</p>', '', '', '', 0, 'attunda-tingsrtt-jobs-in-sollentuna-a-142', '212.214.188.54', NULL, NULL, 'excell', 0, 'a', NULL, NULL, 'a', 'a', 'a', 'a', NULL, 0, 0, 0, 0, ''),
(143, 211, 'Rekryterare', 211, 18, '21000-25000', '2018-01-31', 'blocked', 'no', 'Sweden', '2018-05-31', '', 'BA', '1', 'Sollentuna', 'Full Time', 1, '<p>Hej vi s&ouml;ker en rekryterare p&aring; heltid.</p>', '', '', '', 0, 'attunda-tingsrtt-jobs-in-sollentuna-rekryterare-143', '2.64.140.229', NULL, NULL, 'excel, sales skill , administration', 0, '12345', NULL, NULL, 'Har du tidigare arbetat med rekrytering? ', 'Ja', 'Nej', 'Praktiserat ', NULL, 0, 0, 0, 0, ''),
(145, 209, 'Bmce Dg', 209, 7, 'Trainee Stipend', '2018-02-13', 'blocked', 'no', 'Sverige', '2018-06-13', '', 'SSC', '3', 'Stockholm', 'Full Time', 1, '<p>DEMO JB</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-bmce-dg-145', '105.157.119.243', NULL, NULL, 'banking', 0, '7485', NULL, NULL, '', NULL, NULL, NULL, NULL, 5, 0, 0, 0, 'Notera'),
(146, 209, 'Service', 209, 10, '41000-50000', '2018-02-16', 'blocked', 'no', 'Sverige', '1970-01-01', '', 'Diploma', '4', 'Stockholm', 'Full Time', 1, '<p>blvuicyxtuyz</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-service-146', '90.224.199.144', NULL, NULL, 'word, php, web', 0, '#2018', NULL, NULL, '', NULL, NULL, NULL, NULL, 5, 8, 8, 0, 'note for this job.\r\nionfwubivyu'),
(147, 209, 'Service', 209, 10, '36000-40000', '2018-02-16', 'blocked', 'no', 'Sverige', '2018-02-19', '', 'BE', '4', 'Stockholm', 'Full Time', 1, '<p>job description</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-service-147', '90.224.199.144', NULL, NULL, 'web, word', 0, '#2018', NULL, NULL, '', NULL, NULL, NULL, NULL, 4, 8, 8, 0, 'pih8gd9f78'),
(148, 209, 'Bmce Dg', 209, 7, 'Trainee Stipend', '2018-02-13', 'blocked', 'no', 'Sverige', '2018-06-13', '', 'SSC', '3', 'Stockholm', 'Full Time', 1, '<p>DEMO JB</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-bmce-dg-145', '105.157.119.243', NULL, NULL, 'banking', 0, '7485', NULL, NULL, '', NULL, NULL, NULL, NULL, 5, 0, 0, 1, 'Notera'),
(149, 209, 'Bmce Dg', 209, 7, 'Trainee Stipend', '2018-02-13', 'blocked', 'no', 'Sverige', '2018-06-13', '', 'SSC', '3', 'Stockholm', 'Full Time', 1, '<p>DEMO JB</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-bmce-dg-145', '105.157.119.243', NULL, NULL, 'banking', 0, '7485', NULL, NULL, '', NULL, NULL, NULL, NULL, 5, 0, 0, 1, 'Notera'),
(150, 210, 'Test Job', 210, 3, 'Trainee Stipend', '2018-04-21', 'inactive', 'no', 'Sverige', '2018-08-21', '0', 'BA', 'Fresh', 'N.A', 'Full Time', 1, '<p>s</p>', 'a', 'a', 'a', 0, 'travos-ab-jobs-in-n.a-test-job-150', '41.143.171.223', NULL, NULL, 'php', 0, '', 'Local', 'TEST', '', NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(151, 221, 'Handledare', 220, 35, '26000-30000', '2018-06-07', 'blocked', 'yes', 'Sverige', '2018-10-31', '', 'BA', '2', 'Solna', 'Full Time', 1, '<p><strong>Travos AB, arbetar med integration, arbetsmarknads-program, rekrytering, utbildning och r&aring;dgivning, f&ouml;r n&auml;ringslivet och f&ouml;r den offentliga sektorn. </strong></p>\r\n\r\n<p>Samtliga personer (handledare) som arbetar med deltagare i tj&auml;nsten ska dels uppfylla de generella kompetenskraven samt &auml;ven kvalificera sig genom <strong>alternativ 1</strong> eller <strong>alternativ 2.&nbsp;&nbsp;&nbsp; </strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Generella kompetenskrav:</strong></p>\r\n\r\n<p>&ndash; F&ouml;rm&aring;ga att kommunicera tydligt p&aring; Svenska i tal och skrift.</p>\r\n\r\n<p>&nbsp;&ndash; Mycket goda kunskaper i att anv&auml;nda datorbaserade ordbehandlings</p>\r\n\r\n<p>&ndash; och presentationsprogram, e-post samt internet.</p>\r\n\r\n<p>&ndash; Goda kunskaper i engelska motsvarande Engelska A p&aring; gymnasieniv&aring;.</p>\r\n\r\n<p>&ndash; F&ouml;rm&aring;ga att kommunicera tydligt p&aring; Arabiska eller Tigrinja i tal och skrift.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Alternativ-1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </strong>Krav p&aring; handledarens kompetens &ndash; kvalificering via tj&auml;nstespecifik utbildning och generell arbetslivserfarenhet</p>\r\n\r\n<p>Utbildning: Minst 120 h&ouml;gskolepo&auml;ng (80 po&auml;ng enligt tidigare system) eller motsvarande po&auml;ng fr&aring;n Yrkesh&ouml;gskola inom omr&aring;dena; Arbetsliv, organisation och personalarbete, studie- och yrkesv&auml;gledning, f&ouml;retagsekonomi, arbetslivspsykologi, beteendevetenskap, arbetsterapeut- eller socionomutbildning.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>Arbetslivserfarenhet: Minst tv&aring; &aring;rs arbetslivserfarenhet motsvarande heltid. Personen ska ha erh&aring;llit arbetslivserfarenheten under de senaste fem &aring;ren r&auml;knat fr&aring;n den dag personen tilltr&auml;dde anst&auml;llningen som handledare i den upphandlade tj&auml;nsten.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p><strong>Alternativ- 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n\r\n<p>Krav p&aring; handledarens kompetens &ndash; kvalificering via generell utbildning och tj&auml;nstespecifik arbetslivserfarenhet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>Utbildning: Minst ett &aring;rs heltidsstudier p&aring; eftergymnasial niv&aring; med minst godk&auml;nt resultat. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Arbetslivserfarenhet: Minst tre &aring;rs arbetslivserfarenhet motsvarande heltid i f&ouml;ljande yrke eller arbetsuppgifter: &nbsp; &nbsp; &nbsp; &nbsp;</p>\r\n\r\n<p>&nbsp;&ndash; Arbetsledning med personalansvar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;&ndash; Rekrytering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;&ndash; Omst&auml;llningsarbete f&ouml;r arbetss&ouml;kande&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&ndash; Studie- och yrkesv&auml;gledning&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&ndash; Handl&auml;ggning i personalfr&aring;gor (dock ej enbart personaladministration)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&ndash; Arbete med arbetslivs- och arbetsmarknadsfr&aring;gor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&ndash; Arbete med social- och gruppsykologi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>', 'Timeo Skarander', 'info@travos.se', '0723189657', 0, 'travos-ab-1528392698-jobs-in-solna-handledare-151', '83.183.12.57', NULL, NULL, 'coaching, undervisning, sälj', 0, '001', 'External', '', '8', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 'ÖÄÅ'),
(152, 209, 'Test New Job', 209, 22, 'Trainee Stipend', '2018-08-06', 'blocked', 'no', 'Sverige', '2018-12-06', '', 'BE', 'Fresh', 'Stockholm', 'Full Time', 1, '<p>nkbljvucxf</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-test-new-job-152', '85.224.186.245', NULL, NULL, 'word, php', 0, '3546', 'External', '111111', '', NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(153, 222, 'Test Test Testnew Job', 221, 22, 'Trainee Stipend', '2018-08-06', 'inactive', 'no', 'Sverige', '2018-12-06', '', 'Does not matter', 'Fresh', 'SDERTLJE', 'Full Time', 1, '<p>LBVCX</p>', '', '', '', 0, 'bixma-1533571366-jobs-in-sdertlje-test-test-testnew-job-153', '85.224.186.245', NULL, NULL, 'word, web, php', 0, '', 'External', '', '222', NULL, NULL, NULL, NULL, 0, 0, 0, 0, ''),
(154, 222, 'Test Test Test New Job', 221, 22, 'Trainee Stipend', '2018-08-06', 'blocked', 'no', 'Sverige', '2018-12-06', '0', 'Does not matter', 'Fresh', 'SDERTLJE', 'Full Time', 1, '<p>NBOVIC</p>', '', '', '', 0, 'bixma-1533571366-jobs-in-sdertlje-test-test-test-new-job-154', '85.224.186.245', NULL, NULL, 'web, word, photoshop, php', 0, '543', 'External', '', '222', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '[PBOV'),
(155, 209, 'Testäöåäöåtest', 209, 7, '81000-100000', '2018-09-14', 'archive', 'no', 'Sverige', '2019-01-09', '0', 'MS', '1', 'Stockholm', 'Full Time', 1, '<p>test&Auml;&Ouml;&Aring;&auml;&ouml;&aring;test</p>', '', '', '', 0, 'bixma-jobs-in-stockholm-testtest-155', '140.82.35.206', NULL, NULL, 'testäöåäöåtest', 0, '', 'Internal', '', '', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prohibited_keywords`
--

CREATE TABLE `tbl_prohibited_keywords` (
  `ID` int(11) NOT NULL,
  `keyword` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_prohibited_keywords`
--

INSERT INTO `tbl_prohibited_keywords` (`ID`, `keyword`) VALUES
(8, 'idiot'),
(9, 'fuck'),
(10, 'bitch');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qualifications`
--

CREATE TABLE `tbl_qualifications` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_qualifications`
--

INSERT INTO `tbl_qualifications` (`ID`, `val`, `text`, `display_order`) VALUES
(1, 'BA', 'BA', NULL),
(2, 'BE', 'BE', NULL),
(3, 'BS', 'BS', NULL),
(4, 'CA', 'CA', NULL),
(5, 'Certification', 'Certification', NULL),
(6, 'Diploma', 'Diploma', NULL),
(7, 'HSSC', 'HSSC', NULL),
(8, 'MA', 'MA', NULL),
(9, 'MBA', 'MBA', NULL),
(10, 'MS', 'MS', NULL),
(11, 'PhD', 'PhD', NULL),
(12, 'SSC', 'SSC', NULL),
(13, 'ACMA', 'ACMA', NULL),
(14, 'MCS', 'MCS', NULL),
(15, 'Does not matter', 'Does not matter', NULL),
(16, 'B.Tech', 'B.Tech', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizzes`
--

CREATE TABLE `tbl_quizzes` (
  `ID` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `quizz` text,
  `answer1` varchar(255) DEFAULT NULL,
  `answer2` varchar(255) DEFAULT NULL,
  `answer3` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_quizzes`
--

INSERT INTO `tbl_quizzes` (`ID`, `employer_id`, `title`, `quizz`, `answer1`, `answer2`, `answer3`, `deleted`, `created_at`) VALUES
(1, 210, 'Quizz 1', 'This is a simple Quizz', 'answer 1', 'answer 2', 'answer 3', 1, '2018-02-10 00:00:33'),
(2, 210, 'Quizz Title', 'This is a simple Quizz', 'answer 1', 'answer 2', 'answer 3', 0, '2018-02-10 00:01:46'),
(3, 210, 'Quizz 2', 'This is Quizz 2', 'Ans 1', 'Ans 2', 'Ans 3', 0, '2018-02-10 00:10:19'),
(4, 209, 'quiz test', 'iyfutdyr', '1', '2', '3', 0, '2018-02-16 17:03:37'),
(5, 209, 'Q2', 'Demo', '1', '2', '3', 0, '2018-04-22 09:47:37'),
(6, 221, 'Handledare', '1. Har du en kandidatexamen?\r\n2. Har du arbetslivserfarenheter som motsvarar minst 2 år?\r\n3. Är du en säljare?\r\n', 'Ja', 'Ja', 'Ja', 0, '2018-06-07 12:38:33'),
(7, 222, 'quiz test', '4+4', '1', '5', '8', 0, '2018-08-06 11:04:08'),
(8, 221, 'advokat', 'juridik', 'jurdik', 'juridik', 'juridik', 0, '2018-08-12 10:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requests_info`
--

CREATE TABLE `tbl_requests_info` (
  `ID` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `jobseeker_id` int(11) DEFAULT NULL,
  `sts` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_requests_info`
--

INSERT INTO `tbl_requests_info` (`ID`, `employer_id`, `jobseeker_id`, `sts`) VALUES
(5, 218, 458, 'not approuved'),
(6, 218, 424, 'approuved'),
(13, 218, 456, 'not approuved'),
(14, 221, 462, 'approuved'),
(15, 209, 449, 'approuved'),
(16, 222, 449, 'approuved'),
(17, 222, 465, 'approuved');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salaries`
--

CREATE TABLE `tbl_salaries` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_salaries`
--

INSERT INTO `tbl_salaries` (`ID`, `val`, `text`, `display_order`) VALUES
(1, 'Trainee Stipend', 'Trainee Stipend', 0),
(2, '5000-10000', '5-10', NULL),
(3, '11000-15000', '11-15', NULL),
(4, '16000-20000', '16-20', NULL),
(5, '21000-25000', '21-25', NULL),
(6, '26000-30000', '26-30', NULL),
(7, '31000-35000', '31-35', NULL),
(8, '36000-40000', '36-40', NULL),
(9, '41000-50000', '41-50', NULL),
(10, '51000-60000', '51-60', NULL),
(11, '61000-70000', '61-70', NULL),
(12, '71000-80000', '71-80', NULL),
(13, '81000-100000', '81-100', NULL),
(14, '100000-120000', '101-120', NULL),
(15, '120000-140000', '121-140', NULL),
(16, '140000-160000', '141-160', NULL),
(17, '160000-200000', '161-200', NULL),
(18, '200000-240000', '201-240', NULL),
(19, '240000-280000', '241-280', NULL),
(20, '281000-350000', '281-350', NULL),
(21, '350000-450000', '351-450', NULL),
(22, '450000 or above', '450 or above', NULL),
(23, 'Discuss', 'Discuss', NULL),
(24, 'Depends', 'Depends', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scam`
--

CREATE TABLE `tbl_scam` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `reason` text,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_scam`
--

INSERT INTO `tbl_scam` (`ID`, `user_ID`, `job_ID`, `reason`, `dated`, `ip_address`) VALUES
(1, 210, 13, 'gfhgjhgk jbbv', '2016-12-26 04:07:46', '112.133.246.101'),
(2, 390, 8, 'rrrrrrr', '2017-04-19 10:47:13', '47.11.211.152');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_academic`
--

CREATE TABLE `tbl_seeker_academic` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `degree_level` varchar(30) DEFAULT NULL,
  `degree_title` varchar(100) DEFAULT NULL,
  `major` varchar(155) DEFAULT NULL,
  `institude` varchar(155) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `completion_year` int(5) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_academic`
--

INSERT INTO `tbl_seeker_academic` (`ID`, `seeker_ID`, `degree_level`, `degree_title`, `major`, `institude`, `country`, `city`, `completion_year`, `dated`, `flag`, `old_id`) VALUES
(1, 10, NULL, 'BA', 'test', 'teste e ere', 'United States of America', 'New york', 2012, '2016-03-12 13:05:55', NULL, NULL),
(37, 423, NULL, 'BS', 'software', 'IT institute', 'Paraguay', 'kep', 2022, '2018-01-25 11:36:30', NULL, NULL),
(38, 10, NULL, 'BE', 'NOTHING', 'Like', 'Pakistan', 'Job', 2023, '2018-01-27 03:26:58', NULL, NULL),
(39, 430, NULL, 'PhD', 'Rekrytering', 'handelshögskolan sverige', 'Sweden', 'stockholm', 2012, '2018-01-28 04:48:49', NULL, NULL),
(40, 428, NULL, 'PhD', 'Jurist', 'Luleå Tekniska Universitet', 'Sweden', 'LULEÅ', 2012, '2018-01-28 04:50:10', NULL, NULL),
(41, 429, NULL, 'BA', 'Juristprogrammet', 'Uppsala universitet', 'Sweden', 'Uppsala', 2010, '2018-01-28 04:52:35', NULL, NULL),
(42, 452, NULL, 'BA', 'Jurudik', 'Stockholms universitet', 'Sweden', 'Stockholm stad', 2016, '2018-01-30 13:07:03', NULL, NULL),
(43, 454, NULL, 'BA', 'Human Relations', 'Stockholms universitet', 'Sweden', 'Stockholm', 2014, '2018-01-30 15:34:53', NULL, NULL),
(44, 462, NULL, 'BA', 'Sociologi och socialt utvecklingsarbete', 'Halmstad högskola', 'Sweden', 'Halmstad', 2016, '2018-05-21 09:01:19', NULL, NULL),
(46, 449, NULL, 'BA', 'it', 'boiuvi', 'Pakistan', 'n;buv', 2015, '2018-08-06 11:17:53', NULL, NULL),
(47, 465, NULL, 'BE', 'IT', 'LBVIY', 'Pakistan', 'LBV', 1996, '2018-08-06 11:25:48', NULL, NULL),
(48, 427, NULL, 'BA', 'juridik', 'stockholm universitet', 'Sweden', 'stockholm', 2010, '2018-08-12 10:29:58', NULL, NULL),
(49, 467, NULL, 'Certification', 'it', 'lihoui', 'Sweden', 'SÖDERTÄLJE', 2005, '2018-09-04 06:39:30', NULL, NULL),
(50, 467, NULL, 'BA', 'Teaching', 'solna', 'Sweden', 'Solna', 2007, '2018-09-04 07:00:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_additional_info`
--

CREATE TABLE `tbl_seeker_additional_info` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL COMMENT 'JSON data',
  `interest` varchar(155) DEFAULT NULL,
  `awards` varchar(100) DEFAULT NULL,
  `additional_qualities` varchar(155) DEFAULT NULL,
  `convicted_crime` enum('no','yes') DEFAULT 'no',
  `crime_details` text,
  `summary` text,
  `bad_habits` varchar(255) DEFAULT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_additional_info`
--

INSERT INTO `tbl_seeker_additional_info` (`ID`, `seeker_ID`, `languages`, `interest`, `awards`, `additional_qualities`, `convicted_crime`, `crime_details`, `summary`, `bad_habits`, `salary`, `keywords`, `description`) VALUES
(1, 8, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 9, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa nisl, porttitor id urna sag', NULL, 'no', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa nisl, porttitor id urna sagittis, mollis tristique diam. Donec augue nulla, tempus id egestas finibus, sodales a ligula. Suspendisse lacinia malesuada sapien nec pretium. Curabitur sed augue sed neque vulputate congue at pellentesque ante. Aliquam facilisis cursus eros, in laoreet risus luctus non. Aliquam tincidunt purus in urna molestie, eget aliquet lectus sollicitudin. Proin pretium tellus maximus dolor dapibus aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed bibendum nulla. Nulla ac magna placerat, tristique nisl a, consectetur lectus. Pellentesque quis enim semper, placerat augue vel, faucibus urna. Nullam ut odio volutpat, scelerisque mi ac, ornare libero.', NULL, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa nisl, porttitor id urna sagittis, mollis tristique diam. Donec augue nulla, tempus id egestas finibus, sodales a ligula. Suspendisse lacinia malesuada sapien nec pretium. Curabitur sed augue sed neque vulputate congue at pellentesque ante. Aliquam facilisis cursus eros, in laoreet risus luctus non. Aliquam tincidunt purus in urna molestie, eget aliquet lectus sollicitudin. Proin pretium tellus maximus dolor dapibus aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed bibendum nulla. Nulla ac magna placerat, tristique nisl a, consectetur lectus. Pellentesque quis enim semper, placerat augue vel, faucibus urna. Nullam ut odio volutpat, scelerisque mi ac, ornare libero.'),
(3, 10, NULL, NULL, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convall', NULL, 'no', NULL, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', NULL, NULL, NULL, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.'),
(4, 11, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 12, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 13, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 14, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(350, 411, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(351, 422, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(352, 423, NULL, NULL, NULL, NULL, 'no', NULL, 'jkbiyuf ohh', NULL, NULL, NULL, NULL),
(353, 424, NULL, NULL, NULL, NULL, 'no', NULL, 'Hi , i\'m a front-end & back-end developer\nHope u see my CV\nThanks.', NULL, NULL, NULL, NULL),
(354, 425, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(355, 426, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(356, 427, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(357, 428, NULL, NULL, 'Jag sitter med i styrelsen i 4 börsnoterade företag', NULL, 'no', NULL, 'Erfaren jurist', NULL, NULL, NULL, 'Hitta en roll där jag kan trivas och utvecklas'),
(358, 429, NULL, NULL, 'SAGhahf', NULL, 'no', NULL, 'Hej, \n\nJag är en duktig jurist, och vill gärna komma på en arbetsintervju.', NULL, NULL, NULL, 'eqrgT'),
(359, 430, NULL, NULL, 'CHEF', NULL, 'no', NULL, 'Rekrytering\nJurist examen \nAdvokat examen', NULL, NULL, NULL, 'hej hej hej'),
(360, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(361, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(362, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(363, 431, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(364, 432, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(365, 433, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(366, 434, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(367, 435, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(368, 436, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(369, 437, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(370, 438, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(371, 439, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(372, 440, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(373, 441, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(374, 442, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(375, 443, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(376, 444, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(377, 445, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(378, 446, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(379, 447, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(380, 448, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(381, 449, NULL, NULL, 'lbuviyct', NULL, 'no', NULL, 'proffesq\'n', NULL, NULL, NULL, 'ln;opbiovui'),
(382, 450, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(383, 451, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(384, 452, NULL, NULL, 'Jag tycker om att ta långa skogspromenader på min fritid, samt har jag ett stort intresse inom agili', NULL, 'no', NULL, 'Jag är en driven person med god erfarenhet av administrativa arbetsuppgifter. Min Vision är att när jag går från jobbet skall jag allt arbete vara klart och självklart ligga i fas med tidsplanen!', NULL, NULL, NULL, 'Jurist'),
(385, 453, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(386, 454, NULL, NULL, 'Jag har alltid fått bra bemötande av mina tidigare chefer. \r\n\r\nÄven på min tidigare arbetsgivare ble', NULL, 'no', NULL, 'Hej, Jag heter William Schwarz. Jag har under mitt arbetsliv alltid brunnit för rekrytering och administration!  Min arbetsresa startade som receptionist på Stockholm stad, Det var ett givande arbete med anledning av att jag fick vara social i mitt arbete.', NULL, NULL, NULL, 'Mitt mål är att få arbeta som rekryterare på en trevlig och trivsam organisation!'),
(387, 455, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(388, 457, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(389, 458, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(390, 459, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(391, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(392, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(393, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(394, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(395, 460, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(396, 461, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(397, 462, NULL, NULL, 'van att arbeta', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'Vill få en möjlighet att utvecklas både personligt och yrkesmässigt.'),
(398, 463, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(399, 464, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL),
(400, 465, NULL, NULL, 'OG;UFIYUTYXSKZT', NULL, 'no', NULL, 'ONDQPIBOFUIVY', NULL, NULL, NULL, 'BLOVICOXIZEUY'),
(401, 466, NULL, NULL, NULL, NULL, 'no', NULL, 'https://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobshttps://www.matchadirekt.com/search-jobs', NULL, NULL, NULL, NULL),
(402, 467, NULL, NULL, 'This is testsep achievements', NULL, 'no', NULL, 'New testsep summary', NULL, NULL, NULL, 'This is testsep career objectives.'),
(403, 468, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_applied_for_job`
--

CREATE TABLE `tbl_seeker_applied_for_job` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) NOT NULL,
  `job_ID` int(11) NOT NULL,
  `cover_letter` text,
  `expected_salary` varchar(20) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  `employer_ID` int(11) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `skills_level` text,
  `withdraw` tinyint(1) DEFAULT '0',
  `rate` int(11) DEFAULT '0',
  `comment` text,
  `file_name` varchar(155) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `channel` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_applied_for_job`
--

INSERT INTO `tbl_seeker_applied_for_job` (`ID`, `seeker_ID`, `job_ID`, `cover_letter`, `expected_salary`, `dated`, `ip_address`, `employer_ID`, `flag`, `old_id`, `answer`, `skills_level`, `withdraw`, `rate`, `comment`, `file_name`, `deleted`, `note`, `channel`) VALUES
(1, 9, 145, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa nisl, porttitor id urna sagittis, mollis tristique diam. Donec augue nulla, tempus id egestas finibus, sodales a ligula. Suspendisse lacinia malesuada sapien nec pretium. Curabitur sed augue sed neque vulputate congue at pellentesque ante. Aliquam facilisis cursus eros, in laoreet risus luctus non. Aliquam tincidunt purus in urna molestie, eget aliquet lectus sollicitudin. Proin pretium tellus maximus dolor dapibus aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed bibendum nulla. Nulla ac magna placerat, tristique nisl a, consectetur lectus. Pellentesque quis enim semper, placerat augue vel, faucibus urna. Nullam ut odio volutpat, scelerisque mi ac, ornare libero.', 'Trainee Stipend', '2016-03-12 01:53:57', NULL, 7, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(2, 10, 12, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '21000-25000', '2016-03-12 13:06:43', NULL, 11, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(3, 10, 9, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', 'Trainee Stipend', '2016-03-12 13:07:08', NULL, 8, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(4, 11, 9, 'Test', '5000-10000', '2016-03-28 14:14:16', NULL, 8, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(5, 11, 15, 'Account Officer', 'Trainee Stipend', '2016-03-28 14:14:39', NULL, 14, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(6, 11, 7, 'Account Officer', 'Trainee Stipend', '2016-03-28 14:15:03', NULL, 6, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(7, 12, 15, 'bcchchv', '5000-10000', '2016-03-28 14:47:58', NULL, 14, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(249, 423, 114, 'kjhgv', 'Trainee Stipend', '2018-01-26 13:58:01', NULL, 209, NULL, NULL, 'Bixma', NULL, 1, 0, NULL, '6584671253112463d28fa41c01302af4.docx', 1, '', ''),
(225, 423, 15, 'bh', 'Trainee Stipend', '2018-01-25 11:28:08', NULL, 14, NULL, NULL, NULL, NULL, 0, 0, NULL, 'f65391cb5f83d4f1bc335d9ffeaaf74d.docx', 0, '', ''),
(293, 424, 116, '656', 'Trainee Stipend', '2018-02-10 11:00:36', NULL, 210, NULL, NULL, 'This is a simple Quizz : answer 3 <hr/>This is Quizz 2 : Ans 2 <hr/>', NULL, 0, 0, NULL, '', 1, '', ''),
(237, 10, 2, 'Hi', 'Trainee Stipend', '2018-01-26 03:34:54', NULL, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(274, 10, 116, 's', 'Trainee Stipend', '2018-01-29 16:18:14', NULL, 210, 'Success', NULL, NULL, NULL, 0, 0, NULL, '', 1, '', ''),
(275, 449, 120, 'JKBVYUCTYX', 'Trainee Stipend', '2018-01-30 06:20:58', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '84f8c3226abfcad9c73f814876652e40.rtf$*_,_*$405b41e5221f8175d58598f9655bde71.rtf$*_,_*$e9e4f19f806f236074cc54f5fa1a49d5.rtf', 0, '', ''),
(242, 427, 117, 'bbbbb', '26000-30000', '2018-01-26 13:02:02', NULL, 216, NULL, NULL, NULL, NULL, 0, 0, NULL, '___', 0, '', ''),
(243, 426, 117, 'jbh', 'Trainee Stipend', '2018-01-26 13:11:21', NULL, 216, NULL, NULL, NULL, NULL, 0, 0, NULL, '___', 0, '', ''),
(244, 426, 114, 'm,bn', 'Trainee Stipend', '2018-01-26 13:12:41', NULL, 209, NULL, NULL, 'Bixma', NULL, 0, 0, NULL, '___', 1, '', ''),
(248, 10, 114, 's', 'Trainee Stipend', '2018-01-26 13:44:09', NULL, 209, NULL, NULL, 'Bixma', NULL, 0, 7, 'CMT', '91d0a04552dc8baf00138d36a3d61bbd.jpg$*_,_*$3a04eac4fc243086516f3a171261d63a.png$*_,_*$cb31408e2f0dcf1ca47ebd53ccbf6632.jpg', 1, 'Notera 2', ''),
(277, 9, 128, 'drgfg', 'Trainee Stipend', '2018-01-30 07:37:02', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '569d4cec9f593474f672f175647ee4e0.docx', 1, '', ''),
(247, 427, 114, 'b', 'Trainee Stipend', '2018-01-26 13:35:08', NULL, 209, NULL, NULL, 'Bixma', NULL, 0, 0, NULL, 'e631542adf3714fad3b41bf86435872b.rtf', 1, '', ''),
(250, 423, 117, 'l;knb', 'Trainee Stipend', '2018-01-26 14:03:39', NULL, 216, NULL, NULL, NULL, NULL, 0, 0, NULL, '3d8d7b0439f6689f2659a066a373f5a4.rtf$*_,_*$ff078a7693b6c9b4ff81735ba23db58b.png$*_,_*$f032199c8deaa8de42df235258efa02a.docx', 0, '', ''),
(251, 423, 118, 'Gjfx', 'Trainee Stipend', '2018-01-27 07:36:22', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(285, 449, 127, 'Testing personal letter', 'Trainee Stipend', '2018-01-30 09:48:25', NULL, 209, 'Success', NULL, NULL, NULL, 0, 7, 'U', 'dd4beb0401ddaeae5dc1d75f3ccfcd37.rtf', 1, '', ''),
(254, 428, 120, 'Hej!\r\n\r\nJag söker jobb omgående', '41000-50000', '2018-01-28 04:59:14', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, 'b61674aa34ee3febfbb00fdaabb7ec18.docx', 0, '', ''),
(255, 430, 121, 'Hej jag vill VERKLIGEN ha det här arbetet.', '81000-100000', '2018-01-28 04:59:16', NULL, 211, NULL, NULL, 'Blivande', NULL, 0, 1, '1', '', 0, '', ''),
(256, 429, 121, 'Hej,\n\nJag är mycket intresserad om tjänsten....', '21000-25000', '2018-01-28 04:59:19', NULL, 211, NULL, NULL, 'Ja', NULL, 0, 0, NULL, '', 0, '', ''),
(257, 429, 120, 'Mycket intressant!', '26000-30000', '2018-01-28 05:00:14', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(258, 430, 119, 'hej jag vill verkligen ha det här arbetet', '51000-60000', '2018-01-28 05:01:05', NULL, 215, 'Failure', NULL, '', NULL, 0, 0, NULL, '', 0, '', ''),
(259, 428, 121, 'Jobb behövs omgående', '16000-20000', '2018-01-28 05:01:59', NULL, 211, NULL, NULL, 'Blivande', NULL, 0, 0, NULL, 'd6e0002f71ccde4d741d5dfe2ae98e55.docx', 0, '', ''),
(260, 429, 119, 'Hello', '26000-30000', '2018-01-28 05:02:05', NULL, 215, 'Interview', NULL, '', NULL, 0, 0, NULL, '', 0, '', ''),
(261, 430, 120, 'abc', '36000-40000', '2018-01-28 05:04:13', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(262, 423, 121, 'mbvh', 'Trainee Stipend', '2018-01-28 06:06:59', NULL, 211, NULL, NULL, 'Ja', NULL, 0, 0, NULL, '0a2173045af8221c747412edc63ccec6.txt$*_,_*$386f0b7cf346fdf05ee4e0ca396d0222.rtf$*_,_*$d47645053e47f25381724dc1974b8317.rtf', 0, '', ''),
(263, 432, 121, 'Demo', '16000-20000', '2018-01-29 12:30:28', NULL, 211, NULL, NULL, 'Blivande', NULL, 0, 0, NULL, '', 0, '', ''),
(276, 449, 128, 'jgkf', 'Trainee Stipend', '2018-01-30 06:26:28', NULL, 209, 'Interview', NULL, NULL, NULL, 0, 0, NULL, 'd3cb3aee1f1b099b07a3b73e92576455.rtf', 1, '', ''),
(278, 427, 128, 'Intresserad', 'Trainee Stipend', '2018-01-30 08:29:37', NULL, 209, 'Interview', NULL, NULL, NULL, 0, 0, NULL, '', 1, '', ''),
(279, 427, 120, 'Intresserad', 'Trainee Stipend', '2018-01-30 08:31:26', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(280, 427, 119, 'Intresserad', 'Trainee Stipend', '2018-01-30 08:34:02', NULL, 215, 'Success', NULL, '', NULL, 0, 0, NULL, '', 0, '', ''),
(281, 451, 118, 'Hej!', 'Trainee Stipend', '2018-01-30 08:39:09', NULL, 213, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(286, 453, 135, 'fjgfkjgöskfsjösjöjg', '350000-450000', '2018-01-30 13:36:56', NULL, 211, 'Interview', NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(288, 448, 135, 'demo', 'Trainee Stipend', '2018-01-30 14:52:12', NULL, 211, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(294, 10, 144, 'Demo', '16000-20000', '2018-02-11 16:19:34', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '3f800ed104b58691257be082ce5c380d.docx', 1, '', ''),
(295, 448, 144, 'Demo', 'Trainee Stipend', '2018-02-11 20:27:28', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, 'bb5359ccc6d5f9ea47fbe952203210ad.docx$*_,_*$8c6f17a40e92d1c11057281bc93c2883.pdf', 1, '', ''),
(300, 424, 116, 'sdaz', 'Trainee Stipend', '2018-02-13 22:18:35', NULL, 210, NULL, NULL, 'This is a simple Quizz : answer 1 <hr/>This is Quizz 2 : Ans 1 <hr/>', NULL, 0, 0, NULL, '', 1, '', ''),
(301, 424, 116, 'ssaa', 'Trainee Stipend', '2018-02-13 22:21:03', NULL, 210, NULL, NULL, 'This is a simple Quizz : answer 1 <hr/>This is Quizz 2 : Ans 1 <hr/>', NULL, 0, 0, NULL, '', 1, '', ''),
(302, 448, 145, 'Demo', 'Trainee Stipend', '2018-02-15 23:04:07', NULL, 209, 'Failure', NULL, NULL, NULL, 0, 9, 'Demo\r\nDemo\r\nDemo\r\nDemo', '', 1, '', ''),
(303, 448, 145, 'Demo', 'Trainee Stipend', '2018-02-16 01:07:06', NULL, 209, 'Failure', NULL, NULL, NULL, 0, 6, 'Cmt', '1c01e0564f084c059e6102a038417280.docx', 1, '', ''),
(328, 424, 136, 'Th', '11000-15000', '2018-03-22 09:40:25', NULL, 211, NULL, NULL, 'This is a simple Quizz : answer 1 <hr/>This is Quizz 2 : Ans 1 <hr/>', 'excell :  <hr/>excel :  <hr/>', 1, 0, NULL, '', 0, '', ''),
(329, 424, 143, 'Gggghhhj', '11000-15000', '2018-03-22 15:26:52', NULL, 211, NULL, NULL, '', '', 1, 0, NULL, '5b56aa52e6ad253f4d46dc4119664aa2.jpg', 0, '', ''),
(336, 456, 0, NULL, NULL, '2018-04-16 15:59:50', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(338, 456, 0, NULL, NULL, '2018-04-16 16:03:28', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(339, 448, 0, NULL, NULL, '2018-04-16 16:20:44', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(340, 448, 0, NULL, NULL, '2018-04-16 16:36:07', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(341, 448, 0, NULL, NULL, '2018-04-16 16:37:26', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(342, 448, 0, NULL, NULL, '2018-04-16 16:38:25', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(343, 448, 0, NULL, NULL, '2018-04-16 16:43:22', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(344, 448, 145, 'demo', 'Trainee Stipend', '2018-04-28 18:03:59', NULL, 209, NULL, NULL, NULL, 'bankin : 1 <hr/>', 0, 0, NULL, '35801bba6dca098330c8f3a7876df5f1.docx$*_,_*$939f109261080df7c5901cf83086466c.png$*_,_*$dc9c5de78cc1b698983ef837e3beabba.png', 0, '', ''),
(345, 424, 0, NULL, NULL, '2018-05-14 14:30:07', NULL, 218, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(346, 424, 0, NULL, NULL, '2018-05-14 14:30:34', NULL, 218, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(347, 424, 0, NULL, NULL, '2018-05-14 14:30:47', NULL, 218, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(348, 424, 0, NULL, NULL, '2018-05-20 11:03:58', NULL, 218, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(349, 424, 145, NULL, NULL, '2018-05-20 11:39:18', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '', ''),
(350, 424, 129, NULL, NULL, '2018-05-20 11:39:58', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(351, 463, 140, NULL, NULL, '2018-05-22 06:52:14', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 0, '', ''),
(352, 463, 145, NULL, NULL, '2018-05-22 06:53:39', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 1, '', ''),
(353, 463, 145, NULL, NULL, '2018-05-22 06:54:22', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 1, '', ''),
(354, 463, 145, NULL, NULL, '2018-05-22 06:55:41', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '', 1, '', ''),
(355, 463, 145, NULL, NULL, '2018-05-22 06:58:18', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, 'f45df274fd6a3da5b72ad6b575e36d84.docx', 1, '', ''),
(356, 463, 145, NULL, NULL, '2018-05-22 06:58:41', NULL, 209, NULL, NULL, NULL, NULL, 0, 0, NULL, '35801bba6dca098330c8f3a7876df5f1.docx$*_,_*$939f109261080df7c5901cf83086466c.png$*_,_*$dc9c5de78cc1b698983ef837e3beabba.png', 1, '', ''),
(364, 462, 151, 'l', 'Trainee Stipend', '2018-07-19 06:47:07', NULL, 221, NULL, NULL, NULL, 'coaching :  <hr/>', 0, 0, NULL, '', 1, '', ''),
(358, 424, 133, 'TEST', '5000-10000', '2018-05-24 04:13:04', NULL, 215, NULL, NULL, '', '', 0, 0, NULL, '$*_,_*$', 0, '', ''),
(361, 424, 119, '1', 'Trainee Stipend', '2018-05-24 05:08:13', NULL, 215, NULL, NULL, '', '', 0, 0, NULL, '', 0, '', ''),
(365, 449, 152, ';HIGOUFIYDUTSY', 'Trainee Stipend', '2018-08-06 10:52:00', NULL, 209, NULL, NULL, NULL, 'word : 4 <hr/>php : 8 <hr/>', 0, 0, NULL, '', 0, '', ''),
(362, 462, 151, 'hej jag söker jobb hos er', '26000-30000', '2018-06-14 04:01:52', NULL, 221, 'Failure', NULL, NULL, 'coaching : 10 <hr/>', 0, 0, NULL, '', 1, '', ''),
(363, 462, 151, 'nn', 'Trainee Stipend', '2018-07-19 02:19:31', NULL, 221, NULL, NULL, NULL, 'coaching :  <hr/>', 0, 0, NULL, '', 1, '', ''),
(366, 449, 154, ';nbjkh', 'Trainee Stipend', '2018-08-06 11:14:05', NULL, 222, NULL, NULL, '', 'word : 8 <hr/>php : 9 <hr/>photoshop : 2 <hr/>', 0, 0, NULL, '', 0, '', ''),
(367, 465, 154, 'IBOV', 'Trainee Stipend', '2018-08-06 11:26:28', NULL, 222, NULL, NULL, '', 'word : 7 <hr/>php : 7 <hr/>photoshop : 4 <hr/>', 0, 0, NULL, '', 0, '', ''),
(368, 465, 0, NULL, NULL, '2018-08-09 05:37:30', NULL, 223, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '', ''),
(369, 427, 151, 'hdhdhdhdh', 'Trainee Stipend', '2018-08-12 10:44:01', NULL, 221, NULL, NULL, NULL, 'sälj :  <hr/>coaching :  <hr/>', 0, 0, NULL, '', 0, '', ''),
(370, 462, 151, 'Hej jag söker arbete hos er kolla gärna in min profil', 'Trainee Stipend', '2018-08-13 04:02:09', NULL, 221, 'Failure', NULL, NULL, 'coaching :  <hr/>', 0, 0, NULL, '', 1, '', ''),
(371, 462, 151, 'hej', 'Trainee Stipend', '2018-08-15 05:03:36', NULL, 221, NULL, NULL, NULL, 'coaching :  <hr/>', 0, 0, NULL, '', 1, '', ''),
(372, 462, 151, 'hej hej', 'Trainee Stipend', '2018-08-20 02:29:15', NULL, 221, NULL, NULL, NULL, 'coaching :  <hr/>', 0, 0, NULL, '', 1, '', ''),
(373, 467, 152, ';jhilgu', 'Trainee Stipend', '2018-09-04 06:41:03', NULL, 209, NULL, NULL, NULL, 'word : 6 <hr/>php : 8 <hr/>', 0, 0, NULL, '', 0, '', ''),
(374, 467, 154, ';jhilgu', 'Trainee Stipend', '2018-09-04 06:41:41', NULL, 222, NULL, NULL, '', 'word : 6 <hr/>web : 8 <hr/>php : 9 <hr/>', 0, 0, NULL, '', 0, '', ''),
(375, 467, 151, 'knlbjvkh', 'Trainee Stipend', '2018-09-04 07:12:23', NULL, 221, NULL, NULL, 'juridik : juridik <hr/>', 'coaching : 9 <hr/>undervisning : 9 <hr/>sälj : 9 <hr/>', 0, 0, NULL, '', 0, '', ''),
(376, 462, 151, 'ehj', 'Trainee Stipend', '2018-09-04 08:40:39', NULL, 221, NULL, NULL, 'juridik : jurdik <hr/>', 'coaching :  <hr/>sälj :  <hr/>', 0, 0, NULL, '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_experience`
--

CREATE TABLE `tbl_seeker_experience` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `job_title` varchar(155) DEFAULT NULL,
  `company_name` varchar(155) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `responsibilities` text,
  `dated` datetime DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_experience`
--

INSERT INTO `tbl_seeker_experience` (`ID`, `seeker_ID`, `job_title`, `company_name`, `start_date`, `end_date`, `city`, `country`, `responsibilities`, `dated`, `flag`, `old_id`) VALUES
(1, 9, 'test', 'testete', '2012-02-16', NULL, 'New york', 'United States of America', NULL, '2016-03-12 02:10:41', NULL, NULL),
(60, 423, 'Developer', 'teslok', '2019-01-02', '2018-01-11', 'gooda', 'St Vincent & Grenadines', NULL, '2018-01-25 11:35:42', NULL, NULL),
(61, 10, 'Developer', 'SURNATUREL', '2018-01-25', NULL, 'Nice', 'Macau', NULL, '2018-01-27 03:26:35', NULL, NULL),
(62, 430, 'Chef', 'Hej Aktiebolag', '2018-01-15', '2018-01-30', 'Stockholm', 'Sweden', NULL, '2018-01-28 04:48:00', NULL, NULL),
(63, 428, 'Pizzabud', 'Dominos', '2016-11-15', '2018-01-03', 'LULEÅ', 'Sweden', NULL, '2018-01-28 04:49:19', NULL, NULL),
(64, 429, 'Åklagare', 'Eskilstuna tingsrätt', '2014-01-02', '2017-01-11', 'Eskilstuna', 'Sweden', NULL, '2018-01-28 04:49:19', NULL, NULL),
(65, 429, 'Adminsitratör', 'Göteborgs tingsrätt', '2017-02-02', '2017-03-08', 'Göteborg', 'Afganistan', NULL, '2018-01-28 04:51:58', NULL, NULL),
(66, 452, 'Receptionist', 'Lidingö Stad', '2016-01-27', '2018-01-09', 'Lidingö Stad', 'Sweden', NULL, '2018-01-30 13:06:30', NULL, NULL),
(67, 454, 'Administratör', 'Stockholms Stad', '2014-01-16', NULL, 'Stockholm', 'Sweden', NULL, '2018-01-30 15:33:50', NULL, NULL),
(68, 454, 'Rekryterare', 'Järfälla kommun', '2010-01-14', '2016-01-07', 'järfälla', 'Sweden', NULL, '2018-01-30 15:34:25', NULL, NULL),
(69, 424, 'Developer', 'VPI-INFO', '2017-10-27', NULL, 'Kénitra', 'Morocco', NULL, '2018-02-07 14:51:22', NULL, NULL),
(70, 456, 'TT', 'TT', '2018-04-17', '2018-04-26', 'Kenitra', 'Morocco', NULL, '2018-04-24 15:19:30', NULL, NULL),
(71, 462, 'Handledare stöd och matchning', 'Travos AB', '2018-05-22', NULL, 'Kista', 'Sweden', NULL, '2018-05-21 08:34:24', NULL, NULL),
(72, 462, 'Socialtjänsten Ekonomiskt bistånd', 'Stockholm stad', '2017-07-01', '2017-12-21', 'spånga/tensta', 'Sweden', NULL, '2018-05-21 08:47:40', NULL, NULL),
(73, 449, 'nib', 'nibouv', '2016-08-11', NULL, 'm\'onpib', 'Afganistan', NULL, '2018-08-06 11:17:08', NULL, NULL),
(74, 465, 'OI', 'OPNI', '2013-08-08', NULL, 'NIBO', 'Afganistan', NULL, '2018-08-06 11:24:55', NULL, NULL),
(75, 466, 'SDASF', 'ADSFASDF', '2018-08-23', NULL, 'ASDF', 'Bahrain', NULL, '2018-08-09 05:40:18', NULL, NULL),
(76, 427, 'Handledare', 'dmc', '2015-08-02', NULL, 'stockholm', 'Sweden', NULL, '2018-08-12 10:43:27', NULL, NULL),
(77, 467, 'manager', 'SABA', '2008-09-09', NULL, 'SÖDERTÄLJE', 'Sweden', NULL, '2018-09-04 06:38:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_reference`
--

CREATE TABLE `tbl_seeker_reference` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_reference`
--

INSERT INTO `tbl_seeker_reference` (`ID`, `seeker_ID`, `name`, `title`, `phone`, `email`, `deleted`, `created_at`) VALUES
(2, 424, 's', 'a', 'fg', 'h2', 1, '2018-02-07 16:33:33'),
(3, 424, '1', '2', '3', '4', 1, '2018-02-07 16:34:40'),
(4, 424, 'Ref 1', 'Title--', 'Phoone', 'aa@aaa.aa', 0, '2018-04-24 16:35:43'),
(5, 456, 'N1', 'Mocking Ajax requests', '660050553', 'mouhcin.agoujil@gmail.com', 1, '2018-04-24 15:18:46'),
(6, 424, 'tt', 'tttt', 'ttt', 'tttt', 1, '2018-04-24 16:19:46'),
(7, 424, 'TEST', 't', '@', '@', 1, '2018-04-24 16:35:36'),
(8, 462, 'Timeo ', 'Chef ', '', 'timeo.skarander@travos.se', 0, '2018-05-21 08:54:59'),
(9, 449, 'reference 1 ', 'Title', 'number', 'email', 0, '2018-08-06 11:17:33'),
(10, 465, 'REFERENCE', 'TITLE', '903864', 'KDOJB@B.COM', 0, '2018-08-06 11:25:18'),
(11, 467, 'peref1', 'Manager', '4867687', 'uiy@kby.com', 0, '2018-09-04 06:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_resumes`
--

CREATE TABLE `tbl_seeker_resumes` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `is_uploaded_resume` enum('no','yes') DEFAULT 'no',
  `file_name` varchar(155) DEFAULT NULL,
  `resume_name` varchar(40) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `is_default_resume` enum('no','yes') DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_resumes`
--

INSERT INTO `tbl_seeker_resumes` (`ID`, `seeker_ID`, `is_uploaded_resume`, `file_name`, `resume_name`, `dated`, `is_default_resume`) VALUES
(1, 8, 'yes', 'test-test-8-BiXma.docx', NULL, '2016-03-12 01:44:43', 'yes'),
(384, 10, 'yes', 'jhony-man-BiXma-101518308885.pdf', NULL, '2018-02-11 01:28:06', 'no'),
(5, 11, 'yes', 'kganxx-11-BiXma.docx', NULL, '2016-03-28 14:11:09', 'yes'),
(6, 12, 'yes', 'kacykos-12-BiXma.jpg', NULL, '2016-03-28 14:46:29', 'no'),
(7, 13, 'yes', 'ajay-13-BiXma.txt', NULL, '2016-03-28 17:40:38', 'no'),
(8, 14, 'yes', 'peter-sturm-14-BiXma.pdf', NULL, '2016-03-28 18:18:22', 'no'),
(361, 411, 'yes', 'gfgfgfhh-411-BiXma.docx', NULL, '2018-01-25 09:49:27', 'no'),
(362, 422, 'yes', 'a-422-BiXma.pdf', NULL, '2018-01-25 10:07:35', 'no'),
(398, 424, 'yes', 'ayoub-ezzini-BiXma-4241519768442.pdf', NULL, '2018-02-27 22:54:02', 'no'),
(366, 425, 'yes', 'kali-linux-425-BiXma.pdf', NULL, '2018-01-26 06:02:03', 'no'),
(367, 426, 'yes', 'ramtan-426-BiXma.rtf', NULL, '2018-01-26 12:31:56', 'no'),
(368, 427, 'yes', 'tim-s-427-BiXma.doc', NULL, '2018-01-26 13:01:10', 'no'),
(380, 423, 'yes', 'ram-BiXma-4231517141404.rtf', NULL, '2018-01-28 06:10:04', 'yes'),
(376, 429, 'yes', 'johan-gustafsson-BiXma-4291517137630.docx', NULL, '2018-01-28 05:07:10', 'yes'),
(374, 430, 'yes', 'william-schwarz-BiXma-4301517136904.png', NULL, '2018-01-28 04:55:04', 'yes'),
(375, 428, 'yes', 'fredrik-hrn-BiXma-4281517136909.docx', NULL, '2018-01-28 04:55:09', 'yes'),
(377, 428, 'yes', 'fredrik-hrn-BiXma-4281517138714.docx', NULL, '2018-01-28 05:25:14', 'no'),
(378, 428, 'yes', 'fredrik-hrn-BiXma-4281517138743.docx', NULL, '2018-01-28 05:25:43', 'no'),
(379, 423, 'yes', 'ram-BiXma-4231517141311.rtf', NULL, '2018-01-28 06:08:31', 'no'),
(382, 452, 'yes', 'david-schwarz-452.doc', NULL, '2018-01-30 12:58:28', 'no'),
(383, 454, 'yes', 'william-schwarz-454.pdf', NULL, '2018-01-30 15:32:13', 'no'),
(385, 10, 'yes', 'jhony-man-BiXma-101518311324.docx', NULL, '2018-02-11 02:08:44', 'no'),
(386, 10, 'yes', 'jhony-man-BiXma-101518363989.PNG', NULL, '2018-02-11 16:46:29', 'no'),
(387, 8, 'yes', 'test-test-BiXma-81518376139.docx', NULL, '2018-02-11 20:08:59', 'yes'),
(388, 448, 'yes', 'mouhcin-agoujil-BiXma-4481518376382.docx', NULL, '2018-02-11 20:13:02', 'yes'),
(389, 448, 'yes', 'mouhcin-agoujil-BiXma-4481518376407.pdf', NULL, '2018-02-11 20:13:27', 'no'),
(400, 424, 'yes', 'ayoub-ezzini-BiXma-4241524171977.doc', NULL, '2018-04-19 16:06:17', 'no'),
(399, 457, 'yes', 'arabimosta-457.jpg', NULL, '2018-03-21 17:57:08', 'no'),
(401, 424, 'yes', 'ayoub-ezzini-BiXma-4241524173000.jpg', NULL, '2018-04-19 16:23:20', 'no'),
(403, 465, 'yes', 'ramtannnn-465.jpg', NULL, '2018-08-06 11:23:39', 'no'),
(404, 467, 'yes', 'testsep-467.txt', NULL, '2018-09-04 06:36:19', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker_skills`
--

CREATE TABLE `tbl_seeker_skills` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `skill_name` varchar(155) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seeker_skills`
--

INSERT INTO `tbl_seeker_skills` (`ID`, `seeker_ID`, `skill_name`) VALUES
(1, 8, 'php'),
(2, 8, 'java'),
(3, 8, 'javascript'),
(4, 9, 'html'),
(5, 9, 'css'),
(6, 9, 'photoshop'),
(7, 9, 'illustrator'),
(8, 9, 'js'),
(9, 9, 'jquery'),
(10, 10, 'html'),
(11, 10, 'css'),
(12, 10, 'js'),
(13, 11, 'css'),
(14, 11, 'photoshop'),
(15, 11, 'designer'),
(16, 12, 'prawojazdy c'),
(17, 12, 'dobry zawodowo'),
(18, 12, 'xdddd d ddd'),
(19, 14, 'nothing'),
(20, 14, 'more'),
(21, 14, 'nix'),
(981, 423, 'word'),
(982, 423, 'excel'),
(983, 423, 'ajax'),
(1007, 428, 'entreprenör'),
(985, 424, 'c#'),
(989, 425, 'a'),
(990, 425, 'b'),
(991, 425, 'c'),
(992, 426, 'word'),
(993, 426, 'excel'),
(1004, 426, 'php'),
(996, 425, 'advokat'),
(1070, 424, 'banking'),
(998, 423, 'advokat'),
(999, 411, 'advokat'),
(1000, 11, 'advokat'),
(1091, 427, 'sälj'),
(1090, 427, 'coaching'),
(1089, 427, 'handledare'),
(1077, 462, 'socialvägledare'),
(1006, 10, 'php'),
(1008, 428, 'jurist'),
(1009, 428, 'åklagare'),
(1010, 430, 'jurist'),
(1011, 430, 'administratör'),
(1012, 428, 'administratör'),
(1013, 430, 'advokat'),
(1014, 429, 'administratör, jurist, Åklagare'),
(1015, 429, 'administratör'),
(1016, 429, 'jurist'),
(1017, 429, 'Åklagare'),
(1018, 428, 'advokat'),
(1019, 431, 'css'),
(1020, 431, 'php'),
(1021, 431, 'illustrator'),
(1022, 432, 'developer'),
(1023, 432, 'indesign'),
(1024, 432, 'informÃ¡tica'),
(1025, 435, 'corp mkt'),
(1026, 435, 'direct mkt'),
(1027, 435, 'css'),
(1028, 434, 'a'),
(1029, 434, 's'),
(1030, 434, 'c'),
(1031, 441, 'corp mkt'),
(1032, 441, 'vv'),
(1033, 441, 'indesign'),
(1034, 448, 'informÃ¡tica'),
(1035, 448, 'direct mkt'),
(1036, 448, 'indesign'),
(1037, 449, 'word'),
(1038, 449, 'php'),
(1039, 449, 'photoshop'),
(1040, 451, 'jurist'),
(1041, 451, 'administration'),
(1042, 451, 'excell'),
(1043, 452, 'jurist'),
(1044, 452, 'advokat'),
(1045, 452, 'statligt arbete'),
(1046, 453, 'hr'),
(1047, 453, 'administration'),
(1048, 454, 'rekrytering'),
(1049, 454, 'excell'),
(1050, 454, 'administration'),
(1051, 454, 'statlig enhet'),
(1052, 455, 'word'),
(1053, 455, 'excel'),
(1054, 455, 'power'),
(1055, 456, 'php'),
(1063, 456, 'excel'),
(1069, 424, 'excel'),
(1059, 448, 'excel'),
(1060, 448, 'administratör'),
(1068, 424, 'php'),
(1071, 456, 'informÃ¡tica'),
(1072, 448, 'bankin'),
(1073, 458, 'word'),
(1074, 458, 'php'),
(1075, 458, 'java'),
(1076, 461, 'php'),
(1078, 462, 'stöd och matchning'),
(1079, 462, 'sociologi'),
(1080, 463, 'php'),
(1081, 462, 'coaching'),
(1082, 462, 'exel'),
(1083, 465, 'word'),
(1084, 465, 'php'),
(1085, 465, 'photoshop'),
(1086, 466, 'sadasd'),
(1087, 466, 'sdasd'),
(1088, 466, 'asdasdsd'),
(1092, 462, 'svenska'),
(1093, 424, 'asp'),
(1094, 462, 'sälj'),
(1095, 454, 'sälj'),
(1096, 467, 'word'),
(1097, 467, 'web'),
(1098, 467, 'php'),
(1099, 467, 'coaching'),
(1100, 467, 'undervisning'),
(1101, 467, 'sälj'),
(1102, 462, 'stöd'),
(1103, 468, 'developer'),
(1104, 468, 'direct mkt'),
(1105, 468, 'word');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sessions`
--

CREATE TABLE `tbl_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sessions`
--

INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('fmsqj08jhg1921dve7v7uoufgmni21gu', '66.249.66.71', 1567036043, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363034323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('2bbrrpdnvk3vildkmn35ogkj4mqnmc8h', '66.249.66.73', 1567036056, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363035353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('b81jck0amaefj05iorvvv8ggtiagm34d', '66.249.66.71', 1567036070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363036393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('jh7b1gfutj9ps7el1tf42l6a05fep8c2', '66.249.66.74', 1567036086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363038353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('avasip0c5utmu9ir90u9no3iaro94hga', '66.249.66.71', 1567036110, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363130393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vt2lalh5dee6osjgu9hqra7kd3rcgd83', '66.249.66.73', 1567036146, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363134363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('48c9c4735v3lg05mlf3n3cvchpm8sc3a', '66.249.66.71', 1567036181, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033363138303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('rsnm2kt7bkhq4do8q963683pniuau5f2', '66.249.66.73', 1567037706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033373730363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('mj9k4833fgq131as6rvegegpsquja29r', '66.249.66.71', 1567037836, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033373833363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bl8kg5udjlh3mag6rg9umhsof0c5pqoe', '66.249.66.74', 1567038289, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033383238393b),
('31akh6kb7pdvk10tn4bodc1gmnvrkv54', '66.249.66.71', 1567038669, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033383636393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('mltssr08pasgt26fqh4fhj2caqdrpau9', '66.249.66.74', 1567039315, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373033393331353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0p3dq3v6r4tgj9fjgmmfgec2jainh537', '66.249.66.74', 1567040274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034303237343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('1iuprsukm4lqa272m6aungij11rgvmtp', '171.13.14.45', 1567040899, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034303839373b),
('5sbj9pfd3qsh8a0pathipqa60erptaa8', '66.249.66.71', 1567041258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313235383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('70bkq71qrh91c82ebci6q3gcte907rs0', '66.249.66.71', 1567041295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313239353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('6mq4db992vbg35q0963be9q5egpa68fk', '66.249.66.74', 1567041341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313334313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('3olr5ci1fiipp06aim7olak91gm3hegh', '66.249.66.74', 1567041343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313334323b),
('erl3rq91k0ffjdmr3ehl8ed9h9cjpg0u', '66.249.66.73', 1567041355, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313335353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('1ncgabb2tik3608vuupvtdhcjaif4425', '66.249.66.73', 1567041386, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313338353b),
('ldkll15utn4q48ageu3eken48numclgd', '66.249.66.73', 1567041471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313437313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('52ff0ae3bo4vtvnk9u2olt7jvvtit39v', '66.249.66.73', 1567041475, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313437353b),
('t9lpbsjqh0s0552oq7lsgafcl5it1k44', '66.249.66.71', 1567041489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313438383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('sf7b1bkls209pcqlo23ubq8eciqccgje', '66.249.66.73', 1567041509, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313530383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('j6ef5j9ijolcql4ieot2e1934uli8rgr', '66.249.66.71', 1567041531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313533303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('s978k66sueg0745m23bcmql78v17dji0', '66.249.66.73', 1567041549, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313534383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('3vk3u40sbler6s1km8qtm7o2om43lihs', '66.249.66.71', 1567041554, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313535343b),
('42t58epkiv3qd54pv0223mvtntmnf8t2', '66.249.66.71', 1567041572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313537313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('s8hfoc3ln550em65ai5e3hnb4prjsvgv', '66.249.66.74', 1567041688, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034313638383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('b9t9mn2kerpvi3egr5lgp1212g59aj0f', '66.249.66.71', 1567042172, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323137323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('d4qcb5hn7cqh07h09ooapkfmollqu6d7', '66.249.66.74', 1567042239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323233393b),
('uornrkul8abkm172ft5egtrupg2uqu3a', '66.249.66.73', 1567042300, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323239393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('297l8f35pe4c31td60tjr3pijl4lugrs', '66.249.66.73', 1567042303, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323330333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('crr8p2p07thbs8c4aa8fs9b8j5gm47jm', '66.249.66.71', 1567042311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323331313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('uvg6r1t27q7ds77sfti73dcttkjh8dl4', '66.249.66.71', 1567042318, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323331383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('fehr17uce2uh7if2fdve2mt4bdluig29', '66.249.66.74', 1567042326, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323332353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('at6j2magm04cjrnh38dhg82jgqere3sr', '66.249.66.71', 1567042333, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323333333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('stkuo9rplrok17mtj53nkncj0vilae6e', '66.249.66.71', 1567042342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034323334313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('j7e1nas5hclpba7go8dnhudc8ogeann6', '66.249.66.74', 1567043197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034333139373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('n3jbtn2f2ilf7741gaef3cp603p7mcbp', '66.249.66.71', 1567043207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034333230363b),
('7qudujcdos2pdj96h0tv5ej2rpuikjt8', '66.249.66.73', 1567043796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034333739363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('s9g38akh3rqrh7b92viefg57pmkm9dfu', '66.249.66.74', 1567045122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034353132323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353935363739343635663364223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('qtfl995c9bf3bmuqebk8mvmfn3hvcn43', '66.249.66.71', 1567047489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373438383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1hnhdcg239fh8ssb5mc3rvhn31padhgq', '66.249.66.74', 1567047686, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373638353b),
('9ic5lhohvf4stni7de2brtil0ehva7jg', '66.249.66.73', 1567047700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373639393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ilpk7s0ocibc6anbh8dhhqua82uaruul', '66.249.66.73', 1567047701, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373639393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('1ejnv25jfo712ipif1ob6cg2cpva6d9n', '66.249.66.71', 1567047704, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373730333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('rdpq7strlgd33g6tqi0pcfkt5pj58e6a', '66.249.66.74', 1567047712, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373731323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('j7tq87oopdh66gpon2r8n0omtqfnbn55', '66.249.66.73', 1567047894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034373839333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('grp4ku2gqj5rdbpv3n5imon59vsq59ob', '66.249.66.73', 1567048037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034383033363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('s1h80dgrj2tv5gjs8f7bnjgnqbvhkd68', '66.249.66.74', 1567048721, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034383732313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('r0ui8u46pfhc7acakr3m5p3tcqht875l', '66.249.66.74', 1567048889, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034383838393b),
('eba0ngkkbc3vorkhb0lsu00r37avd0nv', '66.249.66.74', 1567049004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393030333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('jdfu4hpur4qg5ekcb5sfn7v18c319a4i', '66.249.66.73', 1567049085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393038353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('impv1trr10tsom9e5j290iqsejv6e139', '66.249.66.73', 1567049166, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393136353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('fqagbr092a3h7992iqgip37nj47v149f', '66.249.66.71', 1567049248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393234373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('icussuuf71n5k4ctabjmkdu3ar3v2jr0', '66.249.66.74', 1567049330, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393333303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('62mhn7rqj27o69bkdehv7m29h96ln3ph', '66.249.66.74', 1567049376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393337363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('jcv1gr1f04omtnvsc62ge6rfab3vhfer', '66.249.66.73', 1567049380, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393338303b),
('dt4tlkr6mjscu83fcddk6m13619c2pki', '66.249.66.73', 1567049947, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373034393934373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('p1g4jn6jjmlll0fhaerm6gi7h2gcc4op', '66.249.66.74', 1567052324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035323332343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('rgak3ns55pedu560ac3si6u35n6tjv96', '66.249.66.74', 1567052532, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035323533323b),
('4sbb4k2r3b2fao0a6tasd3oi08pbohe6', '66.249.66.71', 1567053940, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035333934303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('6orqp87j93jneovkdo7p6doe6sk9e84d', '66.249.66.74', 1567054278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035343237383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('5q45te57mds55hp0p5mvdvdeqp9532gk', '66.249.66.74', 1567054282, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035343238313b),
('rgd57pnq4iqfol5p8bfb3lq2jasssj2b', '66.249.66.74', 1567055361, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035353336313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('7jpvhfp9589ml3s95skniesnqple36mb', '66.249.66.71', 1567055981, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035353938313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('gv27oejcr7pqtbq6sjpk54r1phtg8jme', '66.249.66.73', 1567056551, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035363535313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vbt1hltf2hfts6aqofuoifj0m8a8varu', '45.58.142.29', 1567057078, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035373037383b),
('depmj4lg74h9aj4knlcudn1n9t7trhp7', '66.249.66.74', 1567057078, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035373037363b636170576f72647c4e3b),
('65tag9eqjt5fm360t6qj766qghchu4bq', '66.249.66.74', 1567058961, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035383936313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('f9qngqjqgt2rbaq6q2lkbhf2rup03261', '66.249.66.74', 1567059559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393535393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('b46k846d6ev2m9kas6fho6hp0hjvcicf', '66.249.66.71', 1567059561, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393536303b),
('2cg4b1s3eadbv221sqh48gqn804hffgm', '66.249.66.71', 1567059894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393839333b),
('fqqjpn1hpmtqc8gc6l840a0fd9rna705', '66.249.66.71', 1567059937, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393933373b),
('brlphjmhrki4r575e2t4vpqs5pospit7', '66.249.66.71', 1567059971, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393937313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35313a226a6f62732f353536393530323732362d6a6f62732d696e2d736f6c6e612d68616e646c65646172652d3136303f73633d796573223b),
('5n8g8jfkraqme3gml12d86apfpajbfum', '66.249.66.71', 1567059982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373035393938323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('vn0dq8n1v15iqbpt24hv52cnf0m8u92j', '66.249.66.71', 1567060008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303030383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('avgbs7vi3aqq1ujupsoccj9d2sf2v8lk', '66.249.66.71', 1567060020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303031393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('kkb4em2fqe254pn47qnkuk2c800v592p', '66.249.66.71', 1567060030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303033303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('j76ocm853hmb75h605tu8epqmnlflc57', '66.249.66.71', 1567060034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303033333b),
('fvej859cbfrudk55k7vhqlc2mftm7uun', '66.249.66.71', 1567060042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303034313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('i4m97ilkfhirg6dl9vbdhjgpqdri3m0m', '66.249.66.71', 1567060054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303035333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('r0004jp376nnspb46177dd5pl90nhim6', '66.249.66.71', 1567060066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303036363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('aa5ns31hov7meko4f4k3q93v8imrmugh', '66.249.66.71', 1567060080, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303037393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1bqg9h9vll3vqseu4vd5imj3ol231jgo', '66.249.66.71', 1567060093, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303039333b),
('g780tgfqofmojq2bhpqmchqc737864q8', '66.249.66.71', 1567060114, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303131343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('3t1lkmov5ukgps3hs1bclhphut4d3ljq', '66.249.66.71', 1567060133, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303133333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('bi6ib3nhrg5g7pdlkmmhmcvrf6ibfs4q', '66.249.66.74', 1567060154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303135333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vk8191dahoa4aeo0m5ll7vk82g6ei75t', '66.249.66.71', 1567060164, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303136333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('7regj1u9q0kijetb5thq1r8mqvjasl0u', '66.249.66.71', 1567060170, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303137303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('sdb7g6m93p2mv03bj8t1p3m80he68evp', '66.249.66.71', 1567060177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303137373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('j5oq55itcph5t5g07mjrgjaj5iogd3ml', '66.249.66.71', 1567060180, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303138303b),
('khp5pu6n6d6gtcdn53en870sg9vn73g4', '66.249.66.71', 1567060185, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303138343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('q8nospek5o1apnd07i7aigoo9giv2vmm', '66.249.66.71', 1567060192, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303139313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('rtslcoq2rrbv18d3ipp5uafbr0lqd5cn', '66.249.66.71', 1567060207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303230373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('pl2ja2kbem7o6v9ai1j8ljh1e79o9b18', '66.249.66.71', 1567060210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303231303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('cskhdk57mfmngfmm29g8fbjpeccegc8h', '66.249.66.73', 1567060234, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303233343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('d6fhtftisptgokk27bd3hg70jvtq6b2v', '66.249.66.71', 1567060250, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303235303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('2rhdivvh2boeg2r7bgod5ckpbph6oprs', '66.249.66.74', 1567060271, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303237313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('slmalguhn24316f8f85jssjbjnl1mr57', '66.249.66.73', 1567060274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303237343b),
('o9gcf5qumruv3g7g9loqehbt1jp3tdqf', '84.217.207.129', 1567060538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036303533373b),
('p1jn11huhlt6teo9js0tsp0sgjlvjueq', '84.217.207.129', 1567061241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036313234303b),
('2pl7af4k4i7aokpsirlm0qk52r0ajukc', '84.217.207.129', 1567061266, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036313236353b),
('u66dn4dqfcldtlo5sm91bkv1vckdvk2i', '66.249.66.73', 1567061344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036313334343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('hg5nsfuss8d5fegbu378o39t65mh840t', '66.249.66.71', 1567061971, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036313937313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('q2aac9go850sorgr35naq2di2iph8ib9', '66.249.66.73', 1567062092, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323039323b),
('u664mi1nakha7ll21h1611v6v6lpoppv', '66.249.66.71', 1567062109, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323130383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('mtf081j9k6lmisbcbval04h48hqkpq09', '66.249.66.73', 1567062158, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323135383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('uartlp0514vbiq6ojm30d5tp3d2nd1qq', '66.249.66.74', 1567062231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323232393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('km86c252mfin4fhsflnqbibiko6rjqp7', '66.249.66.73', 1567062303, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323330333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('iq1o73a062usshfn1m3timfnrc95so8b', '66.249.66.71', 1567062373, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323337333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5vh3qtqk6jjqp1bt9ne403u4i210u16e', '45.58.142.29', 1567062379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323337393b),
('d7qg372a712uu4112nc2rejm2vbg9s69', '66.249.66.73', 1567062380, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323337383b637074636f64657c733a343a2242345738223b),
('oupdik0grdrf1jsbqn002gib5blem0u1', '66.249.66.73', 1567062421, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323432313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ch84djh2jtgble1h9i8baaei3rf9tkrd', '66.249.66.73', 1567062463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323436333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('9b8q5n9o6ka36e9r9cl8ne1vv2rqggqi', '66.249.66.71', 1567062487, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323438373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('iis5hckjqcm0i2tf1svpmh4jv82ngsd8', '66.249.64.55', 1567062512, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323531323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('5t4h4areqmbru1o8ebr3f5ub257n587k', '45.58.142.29', 1567062517, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323531373b),
('ohuk2j4t9gsedmf2jrhasr6ccgftklen', '66.249.66.71', 1567062517, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323531363b637074636f64657c733a343a2258334644223b),
('mt7fqrff1iltivnl0das245rh6uogso0', '66.249.66.71', 1567062534, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323533343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('e37n1ugio3vjhnnn0vd5efiv4i8rn61r', '66.249.66.71', 1567062553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323535333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('s62d8ajng8tm9lv24406l22cc8hbs5d8', '66.249.66.71', 1567062574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323537343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('6m2qmkq95s05bnl1a58nbatjjnu7psrs', '66.249.66.71', 1567062581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323538313b),
('8flbrisfpo86oqg07t7j34ajtco4ospf', '66.249.66.73', 1567062662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323636323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('2vcbf1sc4pjqqptpb581bbnm5iqfvq3p', '66.249.66.73', 1567062667, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323636363b),
('q23pttthc6bt3m69rufuclnml1b7q228', '66.249.66.71', 1567062684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323638343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('5m6h8terjv4u703s2uh843jamj0hk6tk', '66.249.66.71', 1567062687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323638373b),
('i0lsa5r5dk8nncbommfeqto69d3summ7', '66.249.66.71', 1567062700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323730303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('8m8u01r1ch1bv8l5s1atku78nhmdd2ht', '45.58.142.29', 1567062702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323730323b),
('860qj57i55cfqr1135jcre0ff8e4n2hq', '66.249.66.71', 1567062702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036323730323b637074636f64657c733a343a2242345738223b),
('3tjdk1n8a0h40o1o530tj3an7hoqcips', '66.249.66.71', 1567063713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036333731323b),
('4da7ea6l97kukanp6t91tuvv8bcbo7gf', '66.249.66.74', 1567064350, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343335303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('godd7l7bmmm8cj8drbl75jac4l0d3gl8', '66.249.66.73', 1567064525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343532353b),
('5tk8q458j0hd6um2sje5qk1kmi0fcsqv', '66.249.66.73', 1567064577, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343537363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('efh9j6r72ir1929bnpdrrr2erbb41ij7', '66.249.66.74', 1567064619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343631393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('fgefhdm7ssus4n37mfs0ubgd23bb5tqo', '66.249.66.71', 1567064668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343636383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('nmvfkeg460jg4ost6ff3ij5iv99fi4nv', '66.249.66.71', 1567064720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343731393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('kmu5ne2gc5p2l7bmensho52srrkhsi14', '66.249.66.71', 1567064861, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343836313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('hqg2aku89tq359o6b1d14coithutkgf1', '66.249.66.73', 1567064909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036343930383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('gdtjd8to0viin5th9vb2ptfdrjt07295', '66.249.66.71', 1567065612, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036353631323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5hklgcdn0o9ki720j17p73gdflt972fh', '66.249.66.73', 1567066296, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363239363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('e6k9us16nq8dn7f2esfqe0j3pess4akl', '66.249.66.74', 1567066802, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363830323b),
('qfumg7tca50g69fr55rkb6s129ge24j7', '66.249.66.73', 1567066856, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363835363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('j628msb43k07mlfle14su2po8ofj85tl', '66.249.66.74', 1567066861, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363836303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('qr55lhfovmhcbj9kvfrdh9i25hqrerah', '66.249.66.71', 1567066865, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363836353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ua69b0fffllovg65ncbddnqqakrdvgvs', '66.249.66.71', 1567066870, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363837303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('tscgobs2iuh0jjf95p3i8a7bq9113fl7', '66.249.66.71', 1567066877, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363837363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('o9pg5179ilrhdjcvccr00l2pdbaccq51', '66.249.66.71', 1567066885, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036363838353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('l6kqpbplh97sfuffd4e32ulig27q1tcv', '66.249.66.73', 1567067008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036373030373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('n4rgfhosp8ipaa5dij3hrj2j9t11893t', '66.249.66.71', 1567067540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036373534303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0ag8vqkfrieg7o0pjlhlicpds06gf97s', '66.249.66.74', 1567068277, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383237373b),
('rftlhf8sv6fkvl7nfg8e4c6dtin12kv0', '66.249.66.73', 1567068352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383335323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('rkaiu1lupd28c9k9jc2eqt5ne77rd5db', '66.249.66.74', 1567068406, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383430363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('tvthgulhc69dbl4jkuekkk7vpgu54ola', '66.249.66.71', 1567068453, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383435323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bucgff7l69n7vmuhla8q972vh9k8e628', '66.249.66.74', 1567068501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383530313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('9kgsfepf7pdftf2rbfs85972a54sgva7', '66.249.66.74', 1567068550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383535303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('9vlj245glhatqbv55igsk0p4mph7donc', '66.249.66.74', 1567068601, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383630303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('rff09514k7oeiugnv2o28qktfvtrgn1v', '2.71.0.63', 1567069152, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036383938373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('oiet3oe1llo377akrn05anttfch053ij', '66.249.66.74', 1567069308, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373036393330383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('k87ofvncpo1ikplegcummt0vpu11pppo', '66.249.66.71', 1567070684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037303638343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('1okgbtl3om6ei1rfaib54rgb50mh0pm2', '66.249.66.73', 1567071285, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313238353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('oualn1hesa1t1f5oj9pjsd358k591cl0', '66.249.66.71', 1567071290, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313239303b),
('s1dkfcnrhqabh9rll98tt50alra4lies', '66.249.66.71', 1567071740, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313734303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('h5j8ia805bvao0ttjjps4htu3lr5uaf9', '66.249.66.74', 1567071849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313834383b),
('0d9io0t9f2mg0b8sqaghkcpdl0uimhhu', '66.249.66.73', 1567071873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313837323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('6cd5scajinkrs7kmnbi34oemk7ervj7o', '66.249.66.71', 1567071930, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313932393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('q1knqmg1qv5dqnotdhbtk7tl93858k7p', '66.249.66.73', 1567071968, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037313936383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('be1njl9cu5kg61b10sh1d82uukp9coeu', '66.249.66.74', 1567072044, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037323034343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('b3luead4g25cb9lckaa6l9scverrbcm6', '66.249.66.73', 1567072115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037323131343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('hsocd55pcotcmsnop755f7t5m2u7vbi0', '66.249.66.71', 1567072190, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037323139303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('sp5fagjhhdk5n8e6c8us3v60qiudrp2r', '66.249.66.73', 1567073130, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333133303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ba0jqeqg9meerbqi6knt41dhf715i561', '66.249.66.73', 1567073149, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333134393b),
('aais8ql2a6en2n2cthti842l6af37fa9', '66.249.66.73', 1567073203, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333230333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('jdoeikmpbrkhggsut3mg6j8bkhtfejot', '66.249.66.73', 1567073224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333232343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('icl2gmg3j8j6hftr1kkshpm10a1qj7b2', '66.249.66.71', 1567073257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333235373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('3p3q26cjbd5qaf1ae6b7hjkmebdashpc', '66.249.66.71', 1567073300, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333330303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5p5mnjmne5f14i92bbcnr0inngstjuuh', '66.249.66.73', 1567073341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333334313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('tvjhjsj4fr54dhg4v28m86sdns4ka2gc', '66.249.66.71', 1567073385, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333338343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('o0c4s2bsva5216s2d59cbosinar77kj9', '66.249.66.73', 1567077373, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373337333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ju1n2dckpob889oipgkafff4trrkuta8', '66.249.66.74', 1567077510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373531303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('88r8kpcltppu10a33emlag6t3nf16b4n', '66.249.66.74', 1567077543, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373534333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('avbfu767h3ppthlcjbu7nmlf4h92nnea', '66.249.66.73', 1567077548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373534383b),
('haok6scdk05uvgila50g515lh4bjrlss', '66.249.66.71', 1567077585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373538353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('4f3aie4d43isr22njblin5pgoikqv2lu', '66.249.66.71', 1567077587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373538373b),
('cp2jdfpnqnbcjgm17ls62vgr3jombfdu', '66.249.66.71', 1567077649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373634393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('7if4lelk22540o95dg8k957lbo4saksi', '66.249.66.74', 1567077660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037373636303b),
('08v8p41pod230ut20bhps42uteiadb3l', '66.249.66.71', 1567080826, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038303832363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('tvn9h3uiing9ghlmhb8iakp3nsnf78e4', '66.249.66.74', 1567084476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343437363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('8pb70te30op9bku6n2621na1j6ekgjae', '66.249.66.74', 1567084516, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343531363b),
('fhi9kr8obdvqh54kbv4vjvh7n7sk9ut3', '66.249.66.71', 1567084568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343536383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('dj2hkgise2iv2cs47efs8abf42ao74du', '66.249.66.73', 1567084583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343538333b),
('9ikk6ardsgsvuel2ri4onmcmo54oe4f4', '66.249.66.71', 1567084649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343634393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5jnbhp1avre3ophke9k7gh4opum3vlb5', '66.249.66.73', 1567084659, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343635393b),
('sm81ho6ofghdmj82b0p08lfe219cnc77', '66.249.66.74', 1567084704, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343730343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('sf448f8qpg83d4ujqcobpkk2p53836lc', '66.249.66.71', 1567084748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343734383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('g4f0ioe8l9tqftsndcnoutqd80e44u5u', '66.249.66.71', 1567084753, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343735333b),
('23e80liv3re52n3ks02a4jq2nbktqb1p', '66.249.66.73', 1567084879, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343837393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('epcior7dicufcu0icr174jfug1qe089f', '66.249.66.74', 1567088343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038383334333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('4aqbfene8fmgvm5a45413pl5i5c20ubr', '66.249.66.73', 1567089783, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038393738333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('rqghscfrh7d32g7hl7i0i00urls65d7m', '66.249.66.74', 1567089978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038393937383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('hvjrlh0isgc73v7q0qq6leu3bsab63np', '66.249.66.71', 1567090073, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303037333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ibstrp5j76slk9cn6ej6f5ai1hc1g7e8', '66.249.66.71', 1567090075, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303037353b),
('tjm0fee8ano5g5oddber02dfh97qm0e6', '66.249.66.71', 1567090128, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303132383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('pnabv1f1pepjvjtt0ikbhual67hq5bbu', '66.249.66.71', 1567090150, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303135303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('oksb1b4qfmgkkcpqi4gtb2iudclltnvs', '45.58.142.29', 1567090437, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303433373b),
('tfoikon26p4i5mdusouoe1o2bp7ifs5c', '66.249.66.71', 1567090438, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303433373b637074636f64657c733a343a2258334644223b),
('nrcq0a8k1fc39pb3ptqtjvt0b4288vpq', '66.249.66.73', 1567090524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532343b),
('vqrd2m594noargf2odismart8ss3pf56', '66.249.66.74', 1567090528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2247374b35223b),
('psaf523tp04137kuqns599p5aig6q1jk', '66.249.66.74', 1567090526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532363b),
('v5svndk8d8oo41l20ljb8t7f8elhkl7r', '66.249.66.74', 1567090529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2254394c34223b),
('t98vv6k97phjkvjp40t17to3g96st9dd', '45.58.142.29', 1567090528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532383b),
('995bp992e4lpluq4nbcsau0bt612fa9l', '45.58.142.29', 1567090529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303532393b),
('ujdtq298caega6svoa75qpq7iu2k5uag', '66.249.66.71', 1567090556, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303535363b),
('spkjgtom2busnlrc9b1v032gq112k7po', '66.249.66.71', 1567090599, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303539383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34373a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d626d63652d64672d3134353f73633d796573223b),
('46tst8v2bvu1etjlsrs807kq5f80lcrp', '66.249.66.71', 1567090615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303631353b),
('r4rklo1c8bni96m7tthtka16o056ktj4', '66.249.66.74', 1567090639, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303633383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34303a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d626d63652d64672d313435223b),
('jbcfopi3ec9hpp47uhi1t8lrq242f3q2', '66.249.66.71', 1567090660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303636303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2247374b35223b),
('sugd6nnuauqkm5vcura6821j629g7ssl', '45.58.142.29', 1567090660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303636303b),
('8h4u3ujs171fmglm954ldnqnqa3p4urt', '66.249.66.71', 1567090682, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303638313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2258334644223b),
('5olu9gkg1j9gjbkofgiudeqef2fmodnq', '45.58.142.29', 1567090682, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303638323b),
('khtv8023r72o6f1aq8cqh6hpm3svgo7t', '66.249.66.73', 1567090704, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303730333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('svd9efumvlt3cof2g73jppbakecn3ssh', '66.249.66.71', 1567090726, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303732353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('hju1iufgl3ppf5aihibhs4v3uu0irgnj', '66.249.66.74', 1567090748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303734373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('oo9dc2b0fkkht1r20jv0nsmelds5hb77', '66.249.66.71', 1567090769, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303736383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('2vma4i2aej0t2uobf17u069rc2g9r4ru', '66.249.66.71', 1567090791, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303739303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('k05qn1vk5q4b8a35ndh411euh2inlep1', '45.58.142.29', 1567090791, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303739313b),
('u79sd3jph3k4klpuvrcft59qbtcm6620', '66.249.66.71', 1567090972, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303937323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ma2krevujq19cihli5ss7uii9jkiq1ub', '66.249.66.71', 1567090982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039303938323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('u607qet22alr6co3q7ijlahuorglpqbl', '66.249.66.74', 1567091043, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313034333b),
('o4lq11m5f349qa30egrlrrrakfs17nq9', '66.249.66.71', 1567091058, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313035383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('bkk4h0kqbhh4uurt4psit7ga2jpllhgn', '66.249.66.74', 1567091116, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313131363b),
('ga9n61l9823vdsaiabh0ivlr2oai2nfq', '66.249.66.71', 1567091119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313131393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('dphi2ipd40d50losfqjgbls3ojegre23', '66.249.66.71', 1567091121, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313132313b),
('np3fj41u2fs7r71rlvv2gpvqgdba0711', '66.249.66.71', 1567091129, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313132393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('7rs9v6jph4471tqoun6od48cqqhfqbb5', '66.249.66.82', 1567091169, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313136393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('l3gng8m96303n2r796vfi4s5v1macqsi', '66.249.66.82', 1567091224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313232343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('drqh4uj7ju5rgll4f1hkhv1rms08ssef', '66.249.66.83', 1567091258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313235383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('2dbb9undj046qo3tifuf4kde3t089m5f', '66.249.66.82', 1567091260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313236303b),
('923q6ktdkdptip2i6c92qvshaaiihno1', '66.249.66.82', 1567091312, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313331323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('8aakqc68nljdbss0kjm92rk3bojvou9n', '66.249.66.83', 1567091354, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313335333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vssn2ouq3eq9plrqbjfgshp47iciigch', '66.249.66.82', 1567091384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313338333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('tndjqr0bmm2kq8trmpb7ennj9jpb1dle', '66.249.66.82', 1567091416, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039313431363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('675pmuh0sllr0l5qtng5q5epduiefhuk', '66.249.66.84', 1567092004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323030333b),
('lhtkp8tumfb0l6o6a1sfbf9ogbi42mo1', '66.249.66.83', 1567092431, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323433313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('q3mi52tjti91obtj3i3poojq99d13e41', '66.249.66.82', 1567092448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323434383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('bo551lq8bj7ubv2q5cnik3bnl484qu2m', '66.249.66.81', 1567092477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323437373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('puq57rfigdp13s500u1obgi9akqpb7ci', '66.249.66.83', 1567092523, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323532333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('kskgkjddoqc8sf5gchj8p9c0cf82e59p', '66.249.66.81', 1567092524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323532343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('jme45jvalltl8lekqievqb7s2l1sh9vo', '66.249.66.83', 1567092527, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323532373b),
('n1isrd1m73tir14lsuc6u4tfvrbni5c1', '66.249.66.82', 1567092619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323631393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('c3aire597ivr1vhs38j4r8iji1655nns', '66.249.66.81', 1567092627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323632373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('qjbea386qbjl5gmqtco3620i5mkleej3', '66.249.66.81', 1567092631, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323633313b),
('cg5r1k4dskcfb6o4eg2254uiv1naq9qa', '45.58.142.29', 1567092923, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323932333b),
('lsqn6rneo454s0svrl3mrmvdln7urhbl', '66.249.66.74', 1567092923, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039323932323b637074636f64657c733a343a224e325735223b),
('5u1ttma2oa2ms9pn47nv74n9f9itbiq1', '66.249.66.73', 1567093004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333030333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2254394c34223b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('qtep93qu3in52frfud4rkkee67188aea', '45.58.142.29', 1567093004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333030333b),
('da9spfvosudmvtbnssmt1phimciih6vh', '66.249.66.71', 1567093020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333031393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a224e325735223b),
('aihl2mhehavpvjphr714rf20jn0jh086', '45.58.142.29', 1567093020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333032303b),
('35tecl3huggv4mgdjfhrg4tm89gvaq3c', '66.249.66.71', 1567093038, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333033373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34373a226a6f62732f6269786d612d6a6f62732d696e2d6b656e697472612d646576656c6f7065722d3134343f73633d796573223b),
('65gc9jusoiru63bu078sdhufonq9kh59', '66.249.66.71', 1567093066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333036353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34303a226a6f62732f6269786d612d6a6f62732d696e2d6b656e697472612d646576656c6f7065722d313434223b),
('bs3dathfk3t51d6l5sm3bqi3lsman42p', '66.249.66.73', 1567093103, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333130323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2254394c34223b),
('3ljv5a3uflcvuidv34io0hcgp6u1r72v', '45.58.142.29', 1567093102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333130323b),
('nnv3cq9e7jehrd3bs3iq32avloankkt7', '66.249.66.73', 1567093138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333133373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2258334644223b),
('lo1dn2if9m1a2cc3qtn1ef6m511tb2q4', '45.58.142.29', 1567093137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333133373b),
('bl3cco14heebtclq39tp7a8lk753pnra', '66.249.66.71', 1567093174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333137333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('e9kj1ub93dm1jrsgapvf1kdap7p592uo', '45.58.142.29', 1567093174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039333137343b),
('m3l9h284cn7barkfkoedohmt72g7j9b7', '66.249.66.73', 1567095429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039353432383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('qd32db1l1r4md78ieqm184jrd3o88oau', '66.249.66.74', 1567095529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039353532393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('1e77j7vnl18p80bnsqit57lh1rpacdpt', '66.249.66.73', 1567095579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039353537383b),
('17o3qr83cuovmagrk1oqp14sg7v082ei', '66.249.66.73', 1567096697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363639373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('bu9lldbpl0427lb4n6ns9j8vp485husk', '66.249.66.73', 1567096712, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363731323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('4159dct5grmlq6b2it7rma4p1pmmsb2h', '66.249.66.74', 1567096775, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363737353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('pdvs6o93eroc7esqqibfdggh68h9uhj5', '66.249.66.73', 1567096816, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363831363b),
('pmjddquga6hasksklo393kjpmorkc7sm', '66.249.66.71', 1567096869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363836393b),
('qkur61n6jufioml0nh6f1omarana8chd', '66.249.66.71', 1567096886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363838363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('cb69mihqtcjpnf70hm640b5lc8vv12eq', '66.249.66.73', 1567096929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363932383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('nii3pgbi8kcl0sa399fcfv26o555ret2', '66.249.66.73', 1567096966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039363936353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('va5obfjera1sghtmmuf9eicufd2qmq9n', '66.249.66.73', 1567097016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039373031353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('nlb5pmkkdf1qj9e3urjjbmae5ovi6s49', '66.249.66.71', 1567097179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039373137393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('lh36ig0pa9dfm0ffpbbut0iemg2lnq3o', '66.249.66.71', 1567097263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039373236333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('tj82i8spn8arrs7ao3virjruoe4ivm7t', '66.249.66.71', 1567097376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039373337353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bk2tkl57aon0ktcqijcch8jhsd9vpmdl', '66.249.66.71', 1567098936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039383933363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('roc0ik9qm8uijc0erprs4hq7iudgoua2', '66.249.66.73', 1567099095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393039353b),
('ssqc7ncd7hki0u5jb6g15vt8tp44osnn', '66.249.66.73', 1567099141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393134303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('ulqus5m06fd26afllp7lj3oll495dvju', '66.249.66.71', 1567099145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393134343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('aqdknrq8rhh8685kfdij9hl2hkela777', '66.249.66.71', 1567099151, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393135303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('eak67aopb3l5qoseid5akipfpk2mq3he', '66.249.66.71', 1567099157, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393135373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('fvfd46314geve43ealfo056kh4vi5e65', '66.249.66.71', 1567099170, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393136393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('74k5cv1umcc2rpjma2k3e4orb67f6r9i', '66.249.66.71', 1567099180, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393138303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('c5j0uj8vnsm6ep4a670igqmmu8e318qj', '66.249.66.71', 1567099194, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393139333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('7oo2cs86vbdju0k3303hqib0i25h7vpg', '66.249.66.74', 1567099625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393632353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('caeujju4da3p1gahberk7g6help0p71h', '66.249.66.74', 1567104922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130343932323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ljkoa1p7dcf3u0s83b1mlibtvhuum5kv', '66.249.66.73', 1567105522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130353532323b),
('rkg7b7rji96kt51mu89a2c8cbonehqi8', '66.249.66.73', 1567105739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130353733393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('5n9mkgqfgkfkk2btauok5mmd0shhkhqo', '66.249.66.74', 1567105796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130353739363b),
('k893kd69boilvjnooo6tiadu4qifdp6r', '66.249.66.71', 1567106460, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130363436303b),
('qffkf7441nqj0du1g80kr3d3jvg2c3he', '66.249.66.71', 1567106730, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130363733303b),
('gi6umlqode93v2gujec0qlumm957njdi', '66.249.66.73', 1567107374, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373337343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('g8hklvrqkvo4mfm35ramlt4ojt68ssau', '66.249.66.73', 1567107405, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373430343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('vsibcdccrl4cl82h20qf93ld969uaqrf', '66.249.66.74', 1567107438, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373433373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('f4pdnobf9jsp65bm60m2ov74hkkg3pfa', '66.249.66.71', 1567107471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373437303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('blddm065bt64dooos5r3inr9pmb3h480', '66.249.66.71', 1567107497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373439363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('g2ma8j0lvp8s19m6226v35gj2vu509a8', '66.249.66.71', 1567107520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373532303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('452fog0rpobdb37p5lm429495qrovqh5', '66.249.66.73', 1567107550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373535303b),
('k7vs80n2mpfc5r9mm8hjlomp38rd54mh', '66.249.66.73', 1567107581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373538303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('m1bkcn54t78qcfbe8f9m8ea8esqhaj6f', '66.249.66.73', 1567107719, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373731393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('7a8hm1o4j4ec4qvulk0susiecgric20e', '66.249.66.74', 1567107814, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373831333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('pfrsh72la9a8it53uuf4ebvqmntqf1rd', '66.249.66.73', 1567107857, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373835363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('2lif2c9n9u1f4vdedth6ls57iudkc004', '66.249.66.71', 1567107918, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373931373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('t4fhfrq9fr7hqv13p8frd8drgkgkjkqh', '66.249.66.71', 1567107976, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130373937353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('to9gijgio8h9an98j3n8tb9374u1ajg4', '66.249.66.73', 1567108036, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130383033353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('9ggtguk7s6l5meem0bkber20c6t74nhm', '66.249.66.73', 1567108069, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130383036393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('jr16mbckhiejdq09sd96ajlc6hfj2put', '66.249.66.73', 1567108124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130383132333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('31h7fn1g5p6cvj1t7oull19fdgimd2bt', '66.249.66.73', 1567109191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130393139313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('j4ckrcia62a9flhn80fi9dj77ucmseba', '66.249.66.71', 1567111632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313633323b),
('g3360n5mtfgai2lkc9htknmig7vvo5bf', '66.249.66.73', 1567111653, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313635333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('mn35i94smu3udrj5pc6cl9b7iuonap0r', '66.249.66.71', 1567111676, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313637353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('j52q7vegaiir3iu9l6utukulpmb6nqge', '66.249.66.73', 1567111697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313639373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('mlqe7tuv79p01mn9m3ilbgnr6j4v510p', '66.249.66.71', 1567111719, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313731393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('h19467trp0v351q3jucfrbmlme0rnng6', '66.249.66.74', 1567111741, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313734313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('f0t8qbbtql5su534t3k94b9lbspejs2c', '66.249.66.71', 1567111764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313736343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('v2g6s7jkb2hoi6tior2ai268vnp0t5ur', '66.249.66.71', 1567111790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131313739303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('q9obu87n63tbr68l7rbr02puiegd0710', '66.249.66.74', 1567114383, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343338333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('chb0qi7mmdsrk1qhkshj0ncq5ns6aotl', '66.249.66.73', 1567114441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343434313b),
('m0o7srdc5bq1639hiksntki6ssmfm1pb', '66.249.66.74', 1567114503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343530323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('2hue41qenbuuqfvmpu90ek0jr3kd1956', '66.249.66.71', 1567114533, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343533323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('rth1k0mn2krr0lh041t1fr7idp26h215', '66.249.66.74', 1567114580, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343538303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('chhrb1n2ijvtgllq8mei8spl3hgr5o58', '66.249.66.74', 1567114625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343632343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('876lbgg1so2hdpd9dstelilm898daeak', '66.249.66.73', 1567114671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343637313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('86uqlovfipeih2dg8if1rvrep7oa4sbp', '66.249.66.73', 1567114719, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343731383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('fett8fhfeun0mt3im033s1trafmpg25d', '66.249.66.73', 1567114775, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131343737333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('clplgtfhk13utof7jc67n9if41vc3om3', '66.249.66.73', 1567115846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131353834363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('06jkannqkcrkqktkhna3299j4f7q8mjp', '66.249.66.71', 1567117070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131373037303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('sidhukbs0892d3hgvks2huhagbf54vce', '66.249.66.73', 1567118236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131383233363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('qnuilvdb3ilv65kqak2mten5rvdbodq4', '66.249.66.217', 1567118783, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131383738333b),
('9ja3l6f42sim1287ffkadl6ibjat40ue', '66.249.66.217', 1567119418, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373131393431373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('39qi1j3ni8u1s2fo0jpf2vp9ifvapg77', '66.249.66.213', 1567120577, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132303537373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0iurlq2bepdtsu7jah8ufevkjroa4041', '66.249.66.213', 1567121347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313334373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('52055sl6oi8cf3h422d20i0cfoteua7i', '66.249.66.215', 1567121711, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313731313b),
('qj6dt5q0d3lkp1obhu7ib7qc90kq3toc', '66.249.66.213', 1567121809, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313830393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('b5p42f1kutco0nq1iufl810fa3p8jvlr', '66.249.66.215', 1567121817, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313831363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('iev1unr27v6oof38ge3rsun51tsht16t', '66.249.66.215', 1567121820, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313831393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('bkc034n4i8jvvomshn5qfrql029fhbr3', '66.249.66.213', 1567121824, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313832333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('3v35acpulskegu8822p6v43vtn7i6huq', '66.249.66.213', 1567121827, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313832363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vm3gmrqnh9ks4h7sicno8t26f0o854t2', '66.249.66.213', 1567121830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313832393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('4b3c7cq948v7obou942fdq8uuu0v83t6', '66.249.66.213', 1567121833, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132313833333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('3taemai56g031buoasfql6pbkastbfmu', '66.249.66.217', 1567123834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132333833343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('joq7tg4llhijlpt1p6ovcjakrr9no17r', '66.249.66.217', 1567124902, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132343930323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('vkt1qko7lc9qihtntgglek3a6ev4cdga', '66.249.66.215', 1567125030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353033303b),
('kbsgqc3b9fljubjdq475euj2udaujgvh', '66.249.66.217', 1567125136, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353133353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('puul6281nmf8lqlhdrkc8kbhvjgapmns', '66.249.66.213', 1567125179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353137393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ipmho5d27iafhtbr4t0uue0sn42s2gs0', '66.249.66.217', 1567125255, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353235343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('d0lthbha9ds796l0btt4k6014pelmu5q', '66.249.66.217', 1567125341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353334313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('42pa7fpnkbv614oj7dmthep9uclb6neq', '66.249.66.215', 1567125468, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353436373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('a3kuor20larbm30kfefcc4chdme2ems2', '66.249.66.217', 1567125515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353531353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('456ommqasag9bv94epf0sf35c1ovv6e8', '66.249.66.213', 1567125569, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353536393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('h78vt6r1qdrvotqhm9skr89uf97g6dk1', '66.249.66.215', 1567125589, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353538393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('t96t368djkvskp67jlmnvmdut5lfnu5i', '66.249.66.217', 1567125932, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132353932373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('8ups3mutmg2s2rkaon75fsinlv4ng13q', '45.58.142.29', 1567126048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132363034383b),
('na2eolbghqpmblbktqvsigbm52eirppj', '66.249.66.213', 1567126048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132363034373b636170576f72647c4e3b),
('l8s5au9l0ti1o3a6utgguvuiiokd5lsc', '66.249.66.215', 1567126092, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132363039313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('sh15cfgg2dpm2h9uh8jrjjkqc1865tgo', '66.249.66.215', 1567127952, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132373935323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('kvp187v41ijm6u1jl38t2k9g6uh2ao8c', '66.249.66.217', 1567128495, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132383439343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('cfcgdsda1mbaa3p1g384uai9edusvt50', '66.249.66.217', 1567129347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132393334373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('48mjuo0ir4j64f1lfp2v14lg5ij79igm', '66.249.66.217', 1567129398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132393339383b),
('v0of2mmh6ieorf11ha0s1oonp08721n6', '66.249.66.215', 1567129752, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373132393735323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('iaifao4iekejdr5ij3451jogg9a6kb65', '66.249.66.217', 1567130355, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303335353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('nik1i35rqag98npput6jmmoifkuap3si', '66.249.66.213', 1567130363, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303336333b),
('ilpq97mlelvu4s6uokfepsliofmknus5', '66.249.66.213', 1567130824, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303832343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('eldtt0cagc0ftut1921if7u1os9tio6p', '66.249.66.213', 1567130903, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303930333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ttltrc7iatb03vveufn22v69o828riv4', '66.249.66.215', 1567130909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303930393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('l9b00dmnvi2rqjsea2iokid3rp6br2hv', '66.249.66.213', 1567130933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303933333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('32tqhhi3jgpmlobivfpt5uk4nkuglllb', '66.249.66.213', 1567130951, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303935313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('kd95vonasto5k7vq9pptbu66da6shkeh', '66.249.66.213', 1567130984, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133303938343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('q2r1b3g8vs15ipspdl8lg6e6j8kpkgoo', '66.249.66.213', 1567131009, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313030393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('805g7e4l2umgbb4l6pcuasf906ua91s2', '66.249.66.215', 1567131014, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313031343b),
('8iptbb35urjde8er5b4s2ibe5cl4u1fe', '66.249.66.213', 1567131050, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313034393b),
('7t2uqjjgp8p55jtj74rvc34vhjogv2rv', '66.249.66.215', 1567131144, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313134333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('s6cbn16dkkd97kbk2j3h8ikrb2sg6o9i', '66.249.66.213', 1567131187, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313138363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('67217oj162n5t9i6tkhocmshsqmgmh9g', '66.249.66.215', 1567131251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313235303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('qujl141si28k2u4ajiga59h68b7p0ctm', '66.249.66.213', 1567131342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313334313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('fnk81jaoc6e9o84r46euduhsu007mjc7', '66.249.66.215', 1567131427, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313432363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('kvupbf1s5ld1np7j4i3gg9ic4nsku4hb', '66.249.66.213', 1567131518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313531383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('vetfob6h5l5eoeud53f8m64rlqqllbe6', '66.249.66.217', 1567131560, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133313535393b),
('e17rdot61l5tse1injp3tutc02emo17t', '66.249.66.217', 1567132325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323332343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('7d9i95i9s31uja4cb3s8vq3asoi9gs69', '66.249.66.213', 1567132424, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323432333b),
('73jhanbimqk8ehfca6le1bpe57ti1h93', '66.249.66.215', 1567132476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323436393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('8t3smtuumnmokumvsvdp9eluk12g5tpi', '66.249.66.217', 1567132484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323437323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('mp0otoc0g2irt37lq8hio4m5n7mcnfpg', '66.249.66.213', 1567132595, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323539353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('09unhtheeijb8rk0dt6fldd4l4cjm2pc', '66.249.66.215', 1567132595, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323539353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('67rv4j2dpaltjteh2dfcvi77bg100jt4', '66.249.66.215', 1567132606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323630363b),
('b7fcresu3nfa9b701l4386jc7am4nndj', '66.249.66.215', 1567132675, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323634373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('t5qtojme5e9jm8gskobpq4kaod66a000', '66.249.66.217', 1567132689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323638323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('39fk2dsdg5kk9scvnpk3jqo41m0il4d8', '66.249.66.213', 1567132704, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323730323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('2rtour36d51s2ij3vto939s8e2fco7ar', '66.249.66.217', 1567132754, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323735333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('eef2h474qi1s4e21938kpfnfvi9kaumd', '66.249.66.215', 1567132772, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323737323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('11ic3jnum2at8i1ksnm54s5qru9h3o55', '66.249.66.213', 1567132815, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133323831353b),
('mpulk81sdto5vgitkgnuqm3qhhdo30md', '66.249.66.217', 1567133380, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133333338303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('0gcck145e8tki2s8b0j60mhvo0jbi0lr', '66.249.66.217', 1567135769, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133353736393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ds4vq0f9u94fd86b8g58u9g0o7rtat8m', '66.249.66.215', 1567135810, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133353831303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('5rt5e1r56n8ffdkrjg9ca9feq8hq97or', '66.249.66.217', 1567135961, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133353936313b),
('m9sg4e0t9v0tlfrth8e1mjf0g3mmjemu', '66.249.66.213', 1567136035, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363033343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('tppkveq9nm08hsnc63sct0h5c6l76k26', '66.249.66.217', 1567136074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363037333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('m8oh5qlf5n6aa5tuer35lijv9ucmg1bv', '66.249.66.213', 1567136117, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363131363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('s79lv6n0ovip7posv3o41ar0v008d5h2', '66.249.66.217', 1567136193, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363139333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('lr98di437airmoc8v9h58g284v52qpgr', '66.249.66.213', 1567136278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363237373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ksci5dkvpih8ap41gkgelavu3tship34', '66.249.66.215', 1567136363, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363336323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('b988s0levpbjs91dmpra0k7umpv2nanq', '66.249.66.213', 1567136949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363934393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ujsdalop22gi1jfrfa7di4vfhkb0304k', '45.58.142.29', 1567136953, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363935323b),
('qtjdd2v6qvp0qutc5ggf7dbhjm8iug3j', '66.249.66.213', 1567136953, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133363935323b637074636f64657c733a343a2247374b35223b),
('r36rngcsbaehr43ijaklqr2usmavdts5', '66.249.66.215', 1567138508, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383530383b),
('3sdk0nfq3in2tj7apjkd1c81i9jvfqhc', '66.249.66.217', 1567138559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383535393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('80cg80sj9m2ei812smlac5bk3c2cdrdi', '66.249.66.213', 1567138600, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383630303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('j3mji8tv3c3f59qgghl2ek0o85vtdmst', '66.249.66.213', 1567138663, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383636333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('jgjg6122gulm3rft6as9sfmosaueqgpe', '66.249.66.213', 1567138724, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383732323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('3uuusm8eq08lbe5f5fkh57dr8os57r3j', '66.249.66.213', 1567138782, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373133383738323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('lloufj40670e2vltqb9n8ijo16qp8n07', '66.249.66.215', 1567140140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134303134303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('b2hr54fmbt12jm6hss3a6bgdb3cqmpos', '66.249.66.217', 1567140259, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134303235393b),
('2q1olkfd3qjjaom7me3qroqn688jogge', '66.249.66.215', 1567141760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134313735393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('fbc85hfeh78ccseu1hhqbvs2kjdrvo11', '66.249.66.217', 1567142001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323030313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('jrjsrothfcj6jil363b2pstmdljvh55d', '66.249.66.217', 1567142042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323034323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('f2fdjve9n0cfrgq2iu7uk3f2qpbvnsf8', '66.249.66.213', 1567142122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323132323b),
('v4vt56g0qk3ums3cvp7nktn5bk9astbd', '66.249.66.213', 1567142131, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323133313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('m98v2q4fkevma9prqd4bdk585j4fka1a', '66.249.66.213', 1567142141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323134303b),
('p46e6jac34gcuudmo3aanjmclc0s8320', '66.249.66.213', 1567142177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323137363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('c5l4offpisgddkfl1v6tumr0d7glpn0l', '66.249.66.215', 1567142199, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323139393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('qq9ebmgk5ul67kdpob1185sra23orab3', '66.249.66.215', 1567142224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323232333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('ofutvgt8u6up9j7b6udpcu2v2g68pu8i', '66.249.66.213', 1567142250, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323235303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('mdkvuftbdnve3d2gl3itg98ccebt0k74', '66.249.66.213', 1567142274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323237343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('6fg19got07pu528o6dgi78plejmjarv0', '66.249.66.215', 1567142313, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323331333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('9agt0cacjose9m893hpfctf3j4nmn6e6', '66.249.66.217', 1567142340, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323334303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('tekodv7ma00fu5oa5jv5trphc5mcqaf8', '66.249.66.215', 1567142389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323338393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('4fhp0fkr9b39sbko1ha64vmcfpn49nph', '66.249.66.215', 1567142457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323435373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('oosvb519pjgia201o9h6vagvkpg2cs6e', '66.249.66.215', 1567142934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134323933343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hapgslc6lqs3mpqdir9qg806ejevsmur', '66.249.66.215', 1567143005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333030353b),
('cnonnub726sdth19desp5hn3daisknud', '66.249.66.213', 1567143073, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333037333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('t6qakpchbkiulh9oh3eqk2m0htmn29en', '66.249.66.213', 1567143158, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333135373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('91ja1mah0iluthvkeoer0uo0blgc48js', '66.249.66.217', 1567143246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333234353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('olq54t1is7n9t4n5qk2k2g0jnem9qg8t', '66.249.66.213', 1567143334, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333333333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('aicmn48agumg9rjagi5efraanirkuofr', '66.249.66.215', 1567143423, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333432323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ufb2bd0stp2dmchi0hot2bh39bv4j2ia', '66.249.66.217', 1567143515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333531353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('pbumsfcks6pvksue57414ebkl1v3u24d', '66.249.66.217', 1567143554, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134333535343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('4h7ii3s6cbr8r0ntc97t4dbmc50a13bc', '66.249.66.215', 1567146990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134363939303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ie5dvitm63a9vislkvbv32fcgb4g0ddm', '66.249.66.213', 1567147501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373530313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('311ffsh8aacdg7aks8anev6jsh9gl7nq', '45.58.142.29', 1567147522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373532323b),
('td4gt17268h9kihmk5ffh8d74vavsfnp', '66.249.66.215', 1567147522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373532313b637074636f64657c733a343a2242345738223b),
('7g3t608srl3d4vulb4knmhqt1fo5v1rm', '66.249.66.213', 1567147789, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373738383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('hhl0tbgoq8uhan125bo5ojmmgga5uljh', '66.249.66.213', 1567147813, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373831333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0tr7e1cvds4j280tg2is7m0a965e85o5', '66.249.66.213', 1567147820, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373831393b),
('c2guet4v22sqcgf1ahqfcm3mcm0gqrf1', '66.249.66.213', 1567147841, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373134373834313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('81t8m7jj9utvticf9cijcc9tp4kbnfl5', '66.249.66.217', 1567150146, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303134363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('0sbtqasdf9us2vle7es4qjrbs29pppki', '66.249.66.217', 1567150297, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303239373b),
('5h8cdicd4tf6m0p9rg34qeau9esk6los', '66.249.66.213', 1567150316, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303331353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('unhuk9qi0571mf4pvpvvp2n2koervujt', '66.249.66.217', 1567150362, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303336313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('67f54qv2lm613qqsml1v84hoc3k4sp4q', '66.249.66.215', 1567150424, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303432343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('u3evarps6mjjtcud2jn5vu8qsk5k0feu', '66.249.66.213', 1567150523, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303532333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ofrgmdn83ikoq6pvl1jetnllejcvoql5', '66.249.66.215', 1567150614, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303631333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('i2e9du73obr9echqll8nfp23kakkgko1', '66.249.66.217', 1567150712, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303731313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('bqdvi0cvg3n7oia72mcc2l643hc5giv8', '66.249.66.215', 1567150840, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135303834303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('s11n17186pqdnt168avt5vpiafaovnv1', '66.249.66.213', 1567152356, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135323335363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('7poma6p8n3sjdtgkbdrmb0kk7cp4p334', '66.249.66.213', 1567153989, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135333938393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('l118764qluv5v34egqk7lerd0l6koll2', '66.249.66.217', 1567154279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343237383b),
('7j8dku96s6t5mtp15puvaj3uan0f33jn', '66.249.66.217', 1567154457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343435363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('frj9vrjrld7gnv6nh9svlc118ksfiarj', '66.249.66.213', 1567154504, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343530343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('of7qapa9v16gc42ulc4hjp3554fqdm7m', '66.249.66.215', 1567154593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343539333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('3k9jsrvp8lifkdnpd31ljnv1hf4bqh0i', '66.249.66.213', 1567154685, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343638343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('udf9mqsp0untppkpqvt3m8rdk7heu66f', '66.249.66.215', 1567154777, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343737363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('38incmp9r5jpgnem1t95c9ubvtia1el3', '66.249.66.217', 1567154873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343837323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ttku4rp0g5fvkm1ttqoq25k1v1m106ta', '66.249.66.215', 1567154982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135343938323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('3el79is2gae91058mmm8gsrmiv2lu6lh', '66.249.66.213', 1567156706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363730363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('056e7b15m0bjf6umtc17s1l50lsvi6e4', '66.249.66.215', 1567156821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363832313b),
('ho617rpau1djv3e9ierfodrp80raj1nu', '66.249.66.215', 1567156831, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363833303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('g7ge9t3mkr1iqksh45598gpqq6bknrjn', '66.249.66.215', 1567156832, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363833323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('t91nqphlpj23m4adpnqar416qgdhgs99', '66.249.66.213', 1567156834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363833343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('1gj8tl1vn8nedrq77mce0gd35potiji4', '66.249.66.213', 1567156836, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135363833363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('gtjb3se8s827asp1kcn3d7dc7b6p066g', '66.249.66.215', 1567157033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373033323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('3h7majp4onr00rf9dkncte3d47g166ea', '66.249.66.213', 1567157171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373137303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('pem1cgecq3o0i8mqp11chsksvl35i277', '66.249.66.217', 1567157369, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373336383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('bbl71o1c8t486vv59vlupl308e7557p0', '66.249.66.217', 1567157458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373435383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('026boegsm8n53vt89a4mhf0brf99t1rm', '45.58.142.29', 1567157792, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373739323b),
('8094ko8d58cn7irnmj8hteo6unu6lrai', '66.249.66.217', 1567157792, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373739323b637074636f64657c733a343a2247374b35223b),
('ro5k69859801n5or2aftb2fbvq8r6d02', '66.249.66.217', 1567157978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373937373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('uobrnor3er9f2j2s8cr7oatmmt407jug', '45.58.142.29', 1567157978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373937383b),
('nrp9uv77rnlu5a5aak8p28m0faka51r3', '66.249.66.217', 1567157982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373938303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d313237223b),
('27n6q5c1sn0uevh0ejci0mgo91c0vg7p', '66.249.66.213', 1567157985, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373938343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34333a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d3132373f73633d796573223b),
('2rch1af17tjsgqqg12t9mfq82032maj1', '66.249.66.213', 1567157990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373938393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2247374b35223b),
('10ndv110aukoe4e800e7nt64uku0t447', '45.58.142.29', 1567157990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373939303b),
('vhvl91368gqb52pfj0v2nrfo8pe9o6g7', '66.249.66.213', 1567157995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373939343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2258334644223b),
('m8n9juejdfrq7a8ro6c39ku7mcjgjiqf', '45.58.142.29', 1567157995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373135373939343b),
('6ui6ueq4ud69vnocot6jnnap95t7n5m3', '3.113.246.64', 1567166216, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136363231333b),
('r2q67ol6hdfsje1rqlouhct1ilj07id9', '66.249.66.213', 1567166232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136363233323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('he5fjgg78mb1es5d8geg0bumepl6740b', '66.249.66.215', 1567168520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383531393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('48hk0sb67hsbto1c5k4lchfg9e83tg6t', '66.249.66.215', 1567168553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383535333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('mdkpdl3i8ftc0k1bkh5umf963d2es9rg', '66.249.66.215', 1567168557, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383535373b),
('h6vjknk9vo34sapmj7i1t4bngmcnjk8o', '66.249.66.213', 1567168689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383638393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('32vdpmjdi8sifq58q3mbj50p1rh7v8j8', '66.249.66.217', 1567168693, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383639323b),
('2kp3cpkk2n5632ejv2ac65u2kmet4nhr', '66.249.66.213', 1567168731, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383733313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('muildmb6gis707ktbqpiimr3l4bvkmun', '66.249.66.213', 1567168761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383736313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('h5bsmti6202i6de4s0ukie0k2fuhi58m', '66.249.66.217', 1567168765, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373136383736353b),
('9numbheu7uuvncfilserqmbd787bj9od', '66.249.66.217', 1567174044, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343034343b),
('aaklmk4e2t0b4sonfbhtcdag0juqe5q1', '66.249.66.217', 1567174139, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343133393b),
('6tk2dk6khk205mtknfborqapn0h5j1nj', '66.249.66.213', 1567174250, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343235303b),
('ntniqirngmdo7q36lpeiu6tcpjud2b3p', '66.249.66.215', 1567174341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343334313b),
('6cc463kepnbh0fp59uv9eaj47lkbmad7', '66.249.66.213', 1567174443, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343434333b636170576f72647c4e3b),
('rlum96lg5uc469qdefohhk7mcpcdidc4', '66.249.66.211', 1567174544, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343534343b),
('qma2vph02gmooisfhag3h6k1uqaepaj5', '66.249.66.211', 1567174645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343634353b),
('65c2v94tnsp14uc4leomfkshe98g3l5r', '66.249.66.213', 1567174746, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343734363b),
('p8uibrtj0513m9akl3hneldahuhjmk3a', '66.249.66.211', 1567174848, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343834383b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('tqlof0ie99ur7khejufu934p292sj431', '45.58.142.29', 1567174951, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343935313b),
('sbdujp6e72v5khj7goe2blph4paila9a', '66.249.66.211', 1567174951, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137343935303b636170576f72647c4e3b),
('n2n6k8kah7b7j150i103r48ibs4peuv8', '66.249.66.215', 1567175054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137353035343b),
('gffbqtrhh3t0ir5vanp8ev38s14jasvl', '45.58.142.29', 1567175163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137353136333b),
('bm6drp3fs3vlo1igg2u2kq1pms1l12to', '66.249.66.215', 1567175163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137353136333b636170576f72647c4e3b),
('ea8pgspi32lgpqp0v8s4g7tskt3dlqeg', '66.249.66.217', 1567175285, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137353238353b),
('u6alj7qfi3hhkgkhhqss9dcr289m4c7u', '66.249.66.215', 1567175628, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137353632383b),
('doe6n4vjn9basn0pmnadt0tji7ddbs2f', '66.249.66.217', 1567176177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363137363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('8ba6cjjcrrkpjvtsk3e535ivjldj7ggu', '45.58.142.29', 1567176177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363137373b),
('4hoq1onqo2qpj8o71r7tgu68m965pb5s', '66.249.66.217', 1567176201, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363230313b),
('4avjhc76bjpr7jniufmjt3j0sbicediv', '66.249.66.215', 1567176216, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363231353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('1v6uuecuvaa4qa9nqi7gf7plivs4idq9', '45.58.142.29', 1567176216, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363231363b),
('9ashfnq3hpebk7lcliucgttj81b8gied', '66.249.66.213', 1567176231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363233313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2247374b35223b),
('fqt5a6o2k0t9dod85bv1prt4idkuu642', '45.58.142.29', 1567176231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363233313b),
('1vbup46f4aoceajvvq20dgt6kb5b0l5e', '66.249.66.217', 1567176247, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363234373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a224e325735223b),
('5kcpq7jb7758vcia5biokcp9rdcu5eln', '45.58.142.29', 1567176247, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363234373b),
('dole87d5htuid4hihl6g4c6is82udsi5', '66.249.66.215', 1567176276, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363237353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a224e325735223b),
('u2544vfqqdrifueo71ju9jkl0bkbhhvd', '45.58.142.29', 1567176276, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363237363b),
('c3h4nql4ecck2sc4jb9m5qvkui5rdb1p', '66.249.66.217', 1567176307, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363330373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2247374b35223b),
('1mn9v0vu6ku2qk6iulttsmlptvvb8vqb', '45.58.142.29', 1567176307, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363330373b),
('vuvgs3cbevmuce3rknhe627i902f19su', '66.249.66.213', 1567176339, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363333383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2258334644223b),
('34pur5fsmn4em70022709ig5ud52eqbr', '45.58.142.29', 1567176338, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363333383b),
('q7oqna23bah78pbnnj2e6mdqnfn2pc1o', '66.249.66.217', 1567176370, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363336393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35393a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6e65772d6a6f622d706f73742d64657369676e2d3133393f73633d796573223b),
('56ece4jt2k7239lmj3cdviat88oj0us9', '66.249.66.215', 1567176401, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363430303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35323a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6e65772d6a6f622d706f73742d64657369676e2d313339223b),
('n9foci9hhi08pa7vtd2uvm1dpe21qqnt', '66.249.66.215', 1567176432, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363433323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('bsa67ge5v8stej20g27587bce71jm366', '66.249.66.215', 1567176464, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363436333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('6hgelgp71daqthlj0jrueo5kulp3nggc', '66.249.66.215', 1567176496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363439353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1ftr5fs3tilq0nfi8n871nep5rn00dnn', '66.249.66.213', 1567176527, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363532373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('8b5nsiojud82mge8h43bb59lofgk4o0q', '66.249.66.213', 1567176560, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363535393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('81l4856dg42rsfot7osqdbunokoeghv2', '66.249.66.215', 1567176593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137363539323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('l1lprimgmhis478qd8iunjcr50elrrg7', '66.249.66.217', 1567178674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137383637343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('oa7rdji8k354975a54llbvr71j7mauhf', '45.58.142.29', 1567179175, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393137353b),
('hd5vvlkg7cbgimlrmbj6a715boenrfhe', '66.249.66.217', 1567179175, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393137343b637074636f64657c733a343a2242345738223b),
('686ch33aqk535jb58evq51t3it8cegn5', '66.249.66.217', 1567179191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393139303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2254394c34223b),
('thtj72hbphe3mnalsfojl3o8k1qi2a6p', '45.58.142.29', 1567179191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393139313b),
('ujhelv173qces3v44bb7vfncqi8hhes9', '66.249.66.213', 1567179221, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393232303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34333a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d3132383f73633d796573223b),
('3fmh9ninlqae08j277d5q2rvvvh3arka', '66.249.66.213', 1567179274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393237333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d313238223b),
('cqs83pt3u0d35o5ph1c10vl357tffm0d', '66.249.66.215', 1567179325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393332333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a224e325735223b),
('u32dt9pasqo6thm30np2bqv5v3g94m54', '45.58.142.29', 1567179325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393332353b),
('am4p96c8laronuksib925copeagi4o4n', '66.249.66.217', 1567179375, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393337343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2258334644223b),
('bgidug199h4q5qpgo9tsj3abc38rtu6n', '45.58.142.29', 1567179375, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393337353b),
('ar8nfv3j77cb3qtmkriu49ij0rgj97u6', '66.249.66.215', 1567179426, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393432353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2258334644223b),
('j36fqqir818tgvaeodu6ivhlaknj4sd8', '45.58.142.29', 1567179426, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393432363b),
('2ee8ohurvgpvf95ngv7hmuav98fne19g', '66.249.66.213', 1567179477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393437373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2254394c34223b),
('t2cbi6d513i34ke9kdgmurnvqkfmcn5e', '45.58.142.29', 1567179477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393437373b),
('uri1tk6n0fsc75dimker0e6kqqlqpbgb', '66.249.66.217', 1567179531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393533303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2258334644223b),
('6prnscqh6sqbgh0fn28uhhkmsn0mdfkv', '45.58.142.29', 1567179531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393533313b),
('44s98d2aoaofokr5a7qlgkqkf5tnf869', '66.249.66.215', 1567179572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393537323b),
('r068ojd9d2u5k121af398qg5qoon72io', '66.249.66.215', 1567179592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393539313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('evf64qsu5cpg2unoeb2k3tlon76qmfgp', '45.58.142.29', 1567179592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373137393539323b),
('acpt7m7suds2thhnecbmsdd9tp03rpt9', '66.249.66.213', 1567180249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138303234393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('cqk2ijfhpsco8s1lkv27jm69me6jmtf7', '66.249.66.213', 1567181418, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313431373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('88t5voks3a8dtdj2f79tiupp35mm2ekp', '45.58.142.29', 1567181538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313533383b),
('d4dqkpgp7k6tq437lbg7ajabqhrpq7t3', '66.249.66.213', 1567181538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313533363b637074636f64657c733a343a2254394c34223b),
('7drldb4jp47qcqphnghnogojj9d7shkd', '66.249.66.213', 1567181564, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313536343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('9ueql3u5j4h83ivh7u610gdq05aus0cc', '45.58.142.29', 1567181573, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313537333b),
('o7eo9kijg3lf63nn221stlutu373g79p', '66.249.66.213', 1567181573, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313537323b637074636f64657c733a343a2258334644223b),
('org0u59isn3sfn322vfalr8e3nlmen27', '66.249.66.215', 1567181608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313630363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2254394c34223b),
('on3j21jnna2r2kijggdnigcols1bkog5', '45.58.142.29', 1567181608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313630383b),
('h78injkuhrubkgfet7nt49b7e697glbt', '66.249.66.213', 1567181627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313632353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a36313a226a6f62732f65736b696c7374756e612d74696e67737274742d6a6f62732d696e2d65736b696c7374756e612d6a75726973742d3133323f73633d796573223b),
('encdo4iiofg30unc0ten7rq3sulq8ige', '66.249.66.215', 1567181646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313634363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('lhhus7l42hlc26vh0v48j3novincprsd', '66.249.66.213', 1567181678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313637383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35343a226a6f62732f65736b696c7374756e612d74696e67737274742d6a6f62732d696e2d65736b696c7374756e612d6a75726973742d313332223b),
('fs3a5fv75is8vvp89gv1coumd4u5k9ur', '66.249.66.215', 1567181920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313731323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2254394c34223b),
('c7lhf1rm6od1s7b819ibt38grvl20i6k', '66.249.66.215', 1567181735, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313733353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('47j86sqopo6817ngfljbcin08mv2rkkm', '66.249.66.217', 1567181764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313736343b),
('0f7g7ge9pi3ni2rlnbvmfkf6nv7dqtnu', '66.249.66.213', 1567181790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313739303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('nngmjmnshk49tljpqstqp4mjrvbmlgjm', '45.58.142.29', 1567181795, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313739343b),
('ce5617p8fmb1arej5vu49qfljs7ufkhp', '66.249.66.213', 1567181795, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313739343b637074636f64657c733a343a2258334644223b),
('srrkui2m4qitln332umuu146mekib6ee', '66.249.66.213', 1567181813, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313831323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('qunjv2rg98bgl97h3h501egsba1ron6h', '45.58.142.29', 1567181813, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313831333b),
('k5t16c4g5eou7d8q40r1jcb2rkhliq4r', '66.249.66.217', 1567181836, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313833363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('jmj9ed56ematmdnn3di8tah92cds47em', '66.249.66.215', 1567181847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313834373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2254394c34223b),
('qfb15q6fs22cd4mijo759qif2el1ie6p', '45.58.142.29', 1567181847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313834373b),
('bgdmhlnbu4a5pddhmla5l4gdkema4s4k', '66.249.66.213', 1567181860, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313836303b),
('9c82egt4fi5i7oner2getp02st023448', '66.249.66.217', 1567181887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313838363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2258334644223b),
('2kgq2d51hm2ravgs1oe8hmd59r26kf7d', '45.58.142.29', 1567181887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313838373b),
('6sujab5bqavmnb97iam8mh664vk621h8', '66.249.66.213', 1567181894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313839333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2247374b35223b),
('kge86h83ack9n87v1rfsc4goi803act9', '45.58.142.29', 1567181894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313839343b),
('9rrph9a1jq3tliijl6cmt6upcaorcu6a', '66.249.66.213', 1567181902, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313930313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('8ojqe4j7l2ihv3qnsuikiceffrqbolqr', '66.249.66.213', 1567181910, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313930393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2247374b35223b),
('ilaefb6p8stm9kfrvqo0p7adkiem0j01', '45.58.142.29', 1567181910, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313931303b),
('ai371hm90nk489da0cn5ilh4a24kintv', '66.249.66.213', 1567181918, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313931373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('do1u1ko4bh0ct8vn9drfiu25508fdsv3', '45.58.142.29', 1567181920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313932303b),
('u0i8ghpkraog0ngvi0jchigd9lsnvum1', '66.249.66.213', 1567181926, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313932363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('d951jk6bjfgkar9pmtr4npdnesipppth', '66.249.66.213', 1567181935, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313933353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('o16u2aolr13894rid1oejhig4l8drfib', '66.249.66.215', 1567181944, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313934333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('08qfkst2gnvgt8fu2mi31rnscucmbsog', '66.249.66.213', 1567181957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313935363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('k0mahr1ct8501a4oou6fekp6t32jokq0', '66.249.66.213', 1567181964, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313936333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('ndfhe7m4l0dq26csusv8pth6d3i97srb', '66.249.66.213', 1567181970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313936393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('ti53teqkmfqhgb1idu1cjeuhheefj3ce', '66.249.66.213', 1567181977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313937363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('4v8bmd5blgn9lv4rr04v0vgnl2garc83', '66.249.66.213', 1567181983, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313938333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('a9rrj0uq52mfa445nlfrorf37bqrk23e', '66.249.66.213', 1567181989, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313938393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('d5mtvqqdud34e484bptlou44sibkec7m', '45.58.142.29', 1567181991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313939313b),
('krjkfeoii4qnhf6i6nrs6btuf2l0129o', '66.249.66.213', 1567181991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313939313b637074636f64657c733a343a2254394c34223b),
('hh6r07qjn3jfor1e94tmtt46ve063htc', '66.249.66.213', 1567181995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138313939343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('84uh0q1kahf5gqbg5qisippgq7cg47jv', '66.249.66.217', 1567182609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138323630393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('gk9nlqra5da26cetqq2cs5iodujelmni', '66.249.66.215', 1567183590, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138333539303b),
('uuaqtqi71bvr1nn8pf6264443hsfagcu', '84.217.207.129', 1567184944, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138343934343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('1fupjo8m5eihvoc1n7ak7mj8ocmgs217', '84.217.207.129', 1567191877, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139313837373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('0uiaiou4mp209dsb950g5o42cpqut46p', '66.249.66.217', 1567184980, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138343937393b),
('85gepk0kk752vmqnifgjoebelvpd5su7', '66.249.66.213', 1567185036, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353033363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('at6vur0ngvfu7isl47os2lht4qhemvfk', '66.249.66.215', 1567185085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353038343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('3pt3m711l31bc9cmokpuef8ug301ivl2', '66.249.66.215', 1567185138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353133383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('1q8vr56cfnheebtrjegh0d9418a58aqp', '66.249.66.217', 1567185215, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353231343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vu6h9jovlm9vci4916smo1u88vkp33ij', '66.249.66.217', 1567185331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353333313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('b1i25ndkpq8i0kkeb998sl8hjbvjo4b2', '66.249.66.215', 1567185437, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353433373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ot5ual7mnlnr9c9g09d12kmvjdhj18e9', '66.249.66.217', 1567185550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353535303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('etqccj27vi62dnk8gl9dch4mgbtrtsnq', '66.249.66.213', 1567185585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353538353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('gsgeah6pns2thq5v3mrb3cbdqm6t3aeb', '66.249.66.213', 1567185746, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353734363b),
('41faunpk8ajf1n64nhd7l2pnr21u9g6p', '66.249.66.215', 1567185759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353735383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ugqmhu5hbpnkpk7bmvprhep4lbfecjui', '66.249.66.213', 1567185798, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353739373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('muulu2vj9ts6gd3moe48s1346cthft7h', '66.249.66.215', 1567185841, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353834313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('9jldee43h0cio52hieps7mphk7b40505', '66.249.66.215', 1567185921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138353932303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('i0dgomsjc47s5bk3rie37717q5auhnhm', '66.249.66.217', 1567186004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138363030343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ifkmhf2rc8drdi785pn3813a1fhcrk5g', '66.249.66.217', 1567186090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138363038393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ps6hc8n5r98nahh9b6frgs99jfi3i58o', '66.249.66.213', 1567186189, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138363138383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a2272746c223b),
('2h87uugqmeqdtd1ovds9pvsdak8o9g95', '66.249.64.55', 1567187678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373138373637383b),
('ahls573s4ckmcvjjdcadhvvh59okj3ce', '40.77.188.166', 1567190325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139303332353b),
('c6e5h0co3oi82i6t4egbfq485vss9ikg', '40.77.188.238', 1567190329, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139303332393b),
('11nq6r4u8t68862ljvptbrsl0nq0gd73', '84.217.207.129', 1567192258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323235383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('4gjp78mt5sjkkuc8cs25thr5jj5mccf3', '94.191.140.216', 1567191994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139313939343b),
('j0rektkogmoaml2347j15c7hun32a7ps', '94.191.140.216', 1567191994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139313939343b),
('neq5jcimq2rvcaf34t4tk8q9h3jrqnbo', '94.191.140.216', 1567192001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('fcrf4demq74ugbcehk1d917f16seg37b', '94.191.140.216', 1567192002, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030323b),
('ofi6qp42ch18r846u0ipki340j4d8afo', '94.191.140.216', 1567192002, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030323b),
('pho2rck6i5vbr2oiead3d59rqq0875cm', '94.191.140.216', 1567192007, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('kc9r7bscthct1sftt0rbtnhsdo2bk4v7', '94.191.140.216', 1567192007, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030373b),
('47kdr4hg9ftcdptmbnp9khhaop1pifef', '94.191.140.216', 1567192008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323030383b),
('6ftn3jmu0i00qhh4qkpi3q56aeiol4bp', '94.191.140.216', 1567192010, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('430o8qll58cdobiab57s6qln89n2h16p', '94.191.140.216', 1567192011, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031303b),
('4ou6tge7ermnk87a0pupgnr5skfd6pfq', '94.191.140.216', 1567192011, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031313b),
('437mso5e54cpspmu578a9bhknud9bsm6', '94.191.140.216', 1567192016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('o32vlu65h8npmi1c9s2laa02rdd4iciv', '94.191.140.216', 1567192016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031363b),
('tt425ij66m57360k579jlel70iq66cmq', '94.191.140.216', 1567192016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031363b),
('bk56crd5mbpu1a30hrql934a42geqc9r', '94.191.140.216', 1567192019, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('it51cg31un6n3v21rfa3fqpe05ci8s17', '94.191.140.216', 1567192020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323031393b),
('fa1p883dseh3elko2lob07v6v38nahas', '94.191.140.216', 1567192020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032303b),
('33831gr7443khfhks0njmff4d891256i', '94.191.140.216', 1567192022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032313b),
('qugdm1qvj5va9bcn0g8a400ofaaaesua', '94.191.140.216', 1567192022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032323b),
('c8krs9uipeklgkf1n0j2pedvrmc9fho3', '45.58.142.29', 1567192026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032363b),
('6f7vmghdpd4dm95rm3o4q4ei1suorb3t', '94.191.140.216', 1567192026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032353b636170576f72647c4e3b),
('srgrt60p7go0q3l1brmv877980h4f2jo', '45.58.142.29', 1567192026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032363b),
('2omc268ulvh21rcv6jfgmj3e2rigv5mi', '94.191.140.216', 1567192026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032363b636170576f72647c4e3b),
('o7mq3s2kg1ltpnh3m38ifneb312pqemu', '94.191.140.216', 1567192027, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323032373b),
('4f53pedv5s81tg64vcvaa2tlo0588tp0', '94.191.140.216', 1567192030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('686c0qsff226489g1hooknjd3e9t48ug', '45.58.142.29', 1567192031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033313b),
('nem512rn4nqs3ao3jbbi63nrldd6j728', '94.191.140.216', 1567192031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033303b636170576f72647c4e3b),
('aoc5asnvv87i27agifov7cip43k4qvaj', '94.191.140.216', 1567192031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033313b),
('aet5uuc5ui5h9f7t3g73dluj0mestel3', '94.191.140.216', 1567192037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('vthi23o9uq0fl4uj8jndio67fetaq9ji', '45.58.142.29', 1567192037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033373b),
('8flbqspuaftifth9ck7d7lvmqi766spl', '94.191.140.216', 1567192037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033373b636170576f72647c4e3b),
('s47u6l2u5ug1v55pmkds292cpdv2gs0s', '94.191.140.216', 1567192037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323033373b),
('m473c6nrll0dhhp865qe22ltrsc02he1', '66.249.64.57', 1567192119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323131393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('8s6t0i76j2vf3sjqml1htt0696i9t8ri', '84.217.207.129', 1567193040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139333034303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('bmg7ojovfupfjvh4g1qddctv9aq6h8eu', '66.249.64.53', 1567192296, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139323239363b),
('cusbhvkvr3msf6qf8d1ppppikcbu59sb', '66.249.64.53', 1567193037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139333033373b),
('kpef15ng31du7bb0e2q35a0d49djcbod', '84.217.207.129', 1567193419, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139333431393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('47kj72820ugmsl9616qe60e3kma1ei88', '84.217.207.129', 1567200260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303236303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('tn3gra1tliabf9r1drlgl8th9ai8c9ur', '66.249.64.53', 1567194526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139343532363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('cm7brpr07lsa2f6f6as1bog9p4rf29ra', '66.249.64.53', 1567195720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139353732303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('utkh1e7nfup3j2d40bg8upr9v70uste1', '66.249.64.53', 1567196321, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139363332313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('vfh2ru3k9v1jf8qvtdlknffrkqeso1t9', '66.249.64.55', 1567196593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139363539323b),
('ane2kc8dhsu6jtlohlpsur6dvt7g720a', '66.249.64.55', 1567196920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139363932303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('dd54jlnehkhke08rs2u309l88hhjot7i', '66.249.64.53', 1567199049, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373139393034393b),
('mro7l9vktfn30unv4htp5s2jse8dino7', '84.217.207.129', 1567200261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303236303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('n58tubbjfulgis91camnu7qnued3oq0q', '66.249.64.53', 1567200546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303534363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('raukuvlosqirpmlmndoi332l89kn06pa', '66.249.64.53', 1567200565, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303536353b),
('1sjhe3eill903lpfct2mohan3jtlgd1b', '66.249.64.53', 1567200572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303537323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('1tofkqovvfku13m68lr4bjqfdkbpopms', '66.249.64.53', 1567200574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303537333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ajr60mrsdf3ars9h1vp2s1ss65g4c5bf', '66.249.64.53', 1567200576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303537353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('0hq3ra1fp5lejmv9ku6dg0188scm0bbh', '66.249.64.53', 1567200579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303537383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('akb6m0g4jq6eu1901aodca52e8te0u4b', '66.249.64.53', 1567200583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303538333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('gupiokmm3fciesjfeob2ceku07jnc3im', '66.249.64.53', 1567200587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303538363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('843i8tjn8r991erenkkonid0jsgg1mk2', '66.249.64.53', 1567200592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230303539313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('j6g3651f2m6di0a6hr8tie4b30li2til', '66.249.64.53', 1567201787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230313738363b),
('ed6n36riav8jiv5oml5h1senrp297gju', '66.249.64.55', 1567205129, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230353132383b),
('4o3tlopukvoqqe3ncnuld0p7hqteo5f6', '66.249.64.53', 1567205356, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230353335363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('u1boqp918721dbetljaivn0ju5j2q674', '66.249.64.53', 1567205397, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230353339373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('t9iuar9tdpul7ii2oop78ubrf06neec9', '66.249.64.55', 1567205612, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230353631323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('iq9osemi8n9uddj7o2nhd6kfrahi9gr6', '66.249.64.55', 1567205726, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230353732363b),
('cnf790h36lbb46k2ciqch2gi6j1nov2c', '66.249.64.53', 1567206645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373230363634353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ub5ifm65gfkav95nq3onmi4ki3t4jnrn', '66.249.64.57', 1567211136, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231313133363b),
('637rkb12veer5oei5k6ie8popm508vi5', '66.249.64.57', 1567212594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231323539343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('8jbhuictp713dcsi0if05r89raaa5q13', '66.249.64.53', 1567214156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231343135363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ak4e8ih3mv3aime0fmckuva84otb1q1c', '66.249.64.55', 1567215151, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231353135313b),
('kmgduhopa7429i1j5u607d0vl2o79kqg', '66.249.64.53', 1567219210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231393230393b),
('b9hit5kbv78blmsrf06isqudoaopfjrf', '66.249.64.55', 1567219583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373231393538333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('so9ib2jgta6bs25pgha4b1flf00hnu1k', '66.249.64.53', 1567220157, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232303135373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('paldprn5j9r3l32jv8v4n8di0tvq7k7v', '5.9.77.102', 1567222099, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232323039393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('4hfidq6rq69ndbb1dce66m5n01tuh8qv', '66.249.64.57', 1567222576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232323537353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('hk0f7dm3k07f9vekcjfkhchq6vbr1rj5', '66.249.64.57', 1567222995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232323939353b),
('i707e7083afrkj33e4pueiuvdpcjprqp', '66.249.64.55', 1567223076, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333037353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('7cm0h0q7kj21klfduhrafvttj7ohft6q', '66.249.64.55', 1567223137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333133363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('noc3ki8o2lpdhp7ohd4uq61b6nft5qm9', '66.249.64.53', 1567223194, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333139343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('539a6885u2r1gau9dctdq8k27u2ifajv', '66.249.64.53', 1567223253, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333235333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('lamhvobe85pfhbvc5ol2n0b1dr4cct6o', '66.249.64.55', 1567223313, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333331323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('kb79m3k65sue176vjpli6ftr7uosahk9', '66.249.64.57', 1567223374, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333337343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1mm4g2643mbh6iko32jpt79nkn04rvnp', '66.249.64.53', 1567223556, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232333535363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('8t0lqqakhp6i6j6g29s5u250i36g4e0v', '66.249.64.53', 1567224732, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232343733323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('e50294lj15vnj6i4t1kheh8pgi9i98f7', '66.249.64.55', 1567225477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232353437353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('d26icv9gjo7ausk0birotvtkq0ev27q5', '66.249.64.55', 1567227082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232373038323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('opmu1fch8ubj2rb7fn9uiisjdkr7erpe', '66.249.64.57', 1567227154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232373135343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ni5bk9pa6vl8ck2c80bn5h41oocgchkh', '66.249.64.55', 1567227180, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232373138303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('k9gjus1e2br5dda9da3qadioi62agu9e', '66.249.64.55', 1567229714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232393731343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('p4grc1krc8j6pf6k5snnlrshklsaksbl', '66.249.64.55', 1567229878, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373232393836333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('fqe9v9g0f8m2r8qp8ihhb5tiur7pu605', '66.249.64.55', 1567230304, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233303330343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('no41bp0pl10d9n8t76gunivn9er7jk95', '66.249.64.57', 1567231077, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313037373b),
('ojjj0dmuejnuasuhfoh0r3j05u4egd6i', '66.249.64.53', 1567231300, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313330303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('gknm51s2q7k57t3fetr4neheidma43rf', '66.249.64.55', 1567231358, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313335373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('9enql9ae6rth6fkoto4jt6u6uun4jrmj', '66.249.64.55', 1567231441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313434313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bo4an60bgfvh2c4pjmc62of1ose1vp2j', '66.249.64.53', 1567231529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313532383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('hf6ndfs7ub06fh5drkqf1m6oj795t08p', '66.249.64.57', 1567231610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313630393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('cd6rcihvcv3m2l94g4vgj53bgrfld64c', '66.249.64.57', 1567231664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313636333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('jda7tn12a72jdpejjtrum0741eu3cgln', '66.249.64.55', 1567231727, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313732373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('v0511751c32k62jhc8tr8pdmch7a93a9', '66.249.64.57', 1567232224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233323232343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('0lqnbuopcte1kf0109bqj5sojm1nh9fk', '66.249.64.53', 1567232540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233323534303b),
('mu094sargquqcb7rbuisrvoafu4mi0rm', '66.249.64.57', 1567233879, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233333836373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('b0csrql9mpd84qmnl8v5ej8g5rs7gu46', '66.249.64.55', 1567234357, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233343335363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353935363739376336363539223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('41tg0cscj83g1itm4r6ucp3sacst1n02', '66.249.64.57', 1567234749, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233343734383b),
('tjem45i3snlebb5bet7l34h7u41nel8u', '66.249.64.55', 1567235182, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233353138323b),
('afc612rbk5j7842is4oqsllhcvjn6spa', '45.58.142.29', 1567236332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233363333323b),
('e9r8kl8fo7b54umui9fbi7hm6i3opgbu', '66.249.64.57', 1567236332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233363333313b637074636f64657c733a343a2254394c34223b),
('rik7br58dshsp5ldo0dvbo8aetde94ub', '66.249.64.55', 1567237867, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233373836333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('j09iocjm538609c3evlk0mbo35fs7ejj', '66.249.64.57', 1567239231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393233313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('2ndrlhc0im3rdot3vpdsrf2qhaaaio9l', '66.249.64.55', 1567239318, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393331373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ncussvbb30b1bjar8l5bv7n19kkiiltv', '66.249.64.53', 1567239344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393334333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('gt01odm16gbv9q0burdijir9jetsrf9c', '66.249.64.55', 1567239499, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393439383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('rn11f8g4dg9t8m5bktnl1ummnm7sh1i7', '66.249.64.53', 1567239521, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393532313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ddg28de3t7t13v77b4kbaj1qvefn2pfh', '66.249.64.53', 1567239570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393536393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ekp0q19kf6ad69shdhd9n3lt8ho526de', '66.249.64.55', 1567239585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233393538353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('qbsspl091r8a4enatfe3turcb2a4835o', '66.249.64.53', 1567242742, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234323734323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('c6luolggbiac5j3jn9qq86ng9m46vm14', '66.249.64.53', 1567243142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234333134323b),
('gpeai4debkc7larkutnm4k6amp9eb9bs', '66.249.64.53', 1567244365, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234343336313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('a1c81g355uio2odbd12bptl5uf6huadh', '66.249.64.53', 1567245230, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234353233303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('l4sea6ql0b6ktfp9cbecun1eenbkn2vj', '66.249.64.57', 1567245886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234353838353b),
('3v3quues2ebbskuev2m7ei2rmnifdcsj', '66.249.64.57', 1567253595, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373235333539353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('eio7sk9l341eufl16272cso9luneg0b5', '66.249.64.53', 1567261210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236313231303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('31j35000gonci03hg0j85fp01uh74m8q', '66.249.64.53', 1567261819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236313831383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('9bgjmpiffllr4q1e1uq3sf417h21mbdb', '66.249.64.53', 1567261823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236313832323b),
('th9qh488omic8al96dut38j33ajoljft', '66.249.64.57', 1567262198, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323139383b),
('ff5o4m7rnqva8v8oh0mvfe0ph0rnd4p1', '94.191.140.216', 1567262839, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323833393b),
('ber9j68s1ddb54krt4ah1uuli5hq12o3', '94.191.140.216', 1567262841, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323834313b),
('i7uboie78448bn4q9mmtp5qpgqs7fenj', '31.13.115.6', 1567262846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323834363b),
('uove2036im46kf0s10s2uru7d45pu7uo', '94.191.140.216', 1567262859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323835393b),
('pbnqn0urd75h1pgrtcmeukieolrchc16', '94.191.140.216', 1567262859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323835393b),
('nnjcbjkaq41t73bf8clpo73q7l038tp1', '83.209.95.55', 1567262943, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323934333b),
('v4qadj7g7f4h5ueq4hmqq6tjf2o6rfkj', '83.209.95.55', 1567262943, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236323934333b),
('onkmdshj7bb9slj0ra977cftddhjddre', '66.249.64.57', 1567263118, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236333131383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('iei5e9klhh34o4g3fte34pb8ndjn1jan', '66.249.64.55', 1567263121, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236333132313b),
('8vssgcaeg42g87s0fveua3tg9rj6v4co', '66.249.64.53', 1567263148, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236333134383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('tfc6pnr8gtjo10t5n4k4gf9gvrhcbbmk', '66.249.64.53', 1567263152, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236333135323b),
('f4b06japgnfnvvtv3fe23q35tlg0247n', '66.249.64.57', 1567267619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373631373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('vr3hrm6it6g99f40qv1rs6pmvjrdnino', '66.249.64.55', 1567267629, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373632373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('6eg7e18v5747qd66h7jhebd1gbeeejbv', '66.249.64.55', 1567267644, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373634333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('2ldbh44qa5bd4frrusbsk7hnpdt2b5v2', '66.249.64.53', 1567267658, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373635373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('mdp7cadas8svugtl607ls4jf9u4o3hsl', '66.249.64.53', 1567267673, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373637323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('baao4hubhaf1mhi2sslfdd3bngdpuku0', '66.249.64.53', 1567267688, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373638373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('dg20h7e6ae16k4dc4br23m0gv9s9dst7', '66.249.64.55', 1567267702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236373730323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('0loe87bt8oth0682sbbhl3c7q2bq7kj9', '66.249.64.53', 1567269829, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236393832393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ljqdlc20okkl4oqibah010bv3hsl1hic', '66.249.64.53', 1567269927, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373236393932373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('1k45lupie5n8vr45eglmk99bvrcc4q29', '66.249.64.57', 1567270407, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237303430373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('heih6foviij50afunt7itmd1ebn65767', '66.249.64.55', 1567270448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237303434383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('a66ol56dalfdbtcth7i0t1o575sf6jqm', '45.58.142.29', 1567270452, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237303435323b),
('0j490rlf1ap6t66j5n8ro9rljkc0mlvg', '66.249.64.55', 1567270452, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237303435313b636170576f72647c4e3b),
('b6nhjbm8phqmqq548t76unrv67i2o7s8', '66.249.64.53', 1567270459, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237303435393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ctrt6k9d79alfcf1usd7bmqiu2kdtdog', '66.249.64.57', 1567272918, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237323931383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('joq1165irbvvtfmg8kl69rlveue74uof', '66.249.64.55', 1567273095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237333039343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('61bleckkaealtj4899ber7nnj4drl73c', '66.249.64.55', 1567273323, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237333332333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('3aoklqbrelpmmi1aoqqgep7m043kjb43', '66.249.64.55', 1567273623, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237333632333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('m1k0s6k6l1cnth9v2cbjnod2rdsviu1r', '66.249.64.57', 1567279919, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373237393931383b),
('kv5niqp5841ip4gom0f4oifflk7q0osn', '66.249.64.57', 1567280018, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373238303031383b),
('6hqff8hgnfr8qa7n361jsh86aramrvs0', '66.249.64.53', 1567323515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332333531343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0beceefpub619vjmalhttn2bsuti5o2h', '66.249.64.57', 1567339804, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393830333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('a9q0qrf9t8sa2tklvdj7hek6v49jltdp', '66.249.64.55', 1567339814, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393831343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('sg931dep82uopf5r36cb62q9gnr5gqvp', '66.249.64.53', 1567339823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393832333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('pishdip7fbkiqmitu7gju6lh001nq8cm', '66.249.64.53', 1567339852, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393835323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('88jqm6fkt35ds98gq7ro3fblftatjtul', '66.249.64.53', 1567339899, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393839393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('i57oq9g7l9a76dcvdra4t6tt5snsckki', '66.249.64.55', 1567339939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393933393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1agddtte3ea2q7f73dv2no8fmm1hjs6p', '66.249.64.53', 1567339942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393934323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('a0p9rkt5tfseqde54jmtbl5bh19vtvd6', '66.249.64.53', 1567339943, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393934323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('29eoqe3hmrg32tjq2gk4f3fkumnibldc', '66.249.64.53', 1567339963, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393936333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('2brhin92b23dqi07g6gd0oom9bbgsfgk', '66.249.64.53', 1567339971, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393937303b),
('a2ovhb5jb6j2jj7uq2lmjmc22r63e012', '66.249.64.53', 1567339979, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393937393b),
('6v0r4pf599hmdobirecq5fka1ffjnp35', '66.249.64.53', 1567339994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393939343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('tpll0poju4vkiv16h8d4efct5eq78tec', '66.249.64.53', 1567340014, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303031343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('d3r4l5cdrmcal19ln8l6hiakkm27912a', '66.249.64.53', 1567340023, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303032333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('sf8ncj6h9cfojgh6gfnuk7uks4rel8i8', '66.249.64.53', 1567340031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303033313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('huooscl9t4v5q78te7scebsj1c1khriv', '66.249.64.53', 1567340033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303033323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('up9p5luip8bmppri91rlt2bbjhou9u4i', '66.249.64.53', 1567340034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303033323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('2sl8hgkaa52pr2vbfhqrsce3kho0051i', '66.249.64.53', 1567340038, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303033373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('2fk3smj5b67m59mmcdjsa28he791dbpp', '66.249.64.53', 1567340042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303034303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('9m2sa33v0f469qgqhe81pv9h1cga2ipg', '66.249.64.53', 1567340045, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303034353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('nmpt2btgmu0eb17mu1jvabaatea6e6h1', '66.249.64.53', 1567340048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303034363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('u1lhv28489tf555d9qc53fno033sai4q', '66.249.64.53', 1567340059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303035393b),
('mce4fv6ropf62mpgvp7mta0955ccj9sc', '66.249.64.57', 1567340104, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303130343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fhpuk6t2t3cfnbe8t94i9gq06106a9db', '66.249.64.53', 1567340111, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303131303b),
('i1lssb3pq2629rs1ppfrm4kd38bhoh1n', '66.249.64.53', 1567340119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303131393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('8dgmkerd1r0vim33cncihdr5mn28e52q', '66.249.64.53', 1567340156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303135363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ps2he2q6vlojs97ismhl1a3pk5d2loq7', '66.249.64.53', 1567340160, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303136303b),
('mt6li4b940e971gpqjmccr42vaeunhrh', '66.249.64.55', 1567340268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303236383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hor0p3t6dgqvuj6hrj62e7dq57njkgt1', '66.249.64.57', 1567340288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303238383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('mal7j886g3dcdmn0kgiq9fnamls1i6fo', '66.249.64.55', 1567340302, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303330323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('94sgsr9r0bl17refqk89q4kki64t8egr', '66.249.64.53', 1567340330, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303331363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('date2ahnl350sfjcd3gj36mgrp5bv2tc', '66.249.64.53', 1567340331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303331373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('jqb8jj52a9fimn6konlat6g0l7bb6b71', '66.249.64.53', 1567340332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303331373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('er41gumehomkuirhq9l6na5520j9j6gi', '66.249.64.53', 1567340336, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303332303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('kcnrodel6cpjdvvgbe9ro5qp4479ov1v', '66.249.64.53', 1567340337, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303332303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('3jo5kj683uidbrcml27jp074n2udhskl', '66.249.64.53', 1567340338, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303332323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('cq3csecsh3qjk9o7tlmmdvqke4rm375d', '66.249.64.53', 1567340340, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303332323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('u5d8tnn3hlgp433njef47mm2gnt8mqch', '66.249.64.53', 1567340334, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303333343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('sn2jl4me1o7q0di3ssidngvtmhbp54h8', '66.249.64.53', 1567340340, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303334303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('j91aqfrt2673orvunc47lb96f7m5oobn', '66.249.64.53', 1567340379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303337393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('lik8fq0rjh6k9lepivhj01kj6ue6l22v', '66.249.64.53', 1567340395, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334303339353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('9d4qa0o89ra9kpgc7o985vl1dm9l1qro', '66.249.64.57', 1567342662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334323636323b),
('v7amnmbf5a9hsmigndkp2qg0l9v5u4j5', '66.249.64.57', 1567353124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335333132343b),
('9ltimmt0tomum7mdje716fc9lro2rk6s', '66.249.64.57', 1567357448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373434363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('18plkvbv42sr0lu4fu0aaiv7k55ds4v6', '66.249.64.55', 1567357527, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373532373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('rs9ln5p8lq6bs6mumtjm9h1kuevvm0ln', '66.249.64.55', 1567357594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373539333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('udnro9662al2osvja87dcbc821otvg6l', '66.249.64.53', 1567357597, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373539363b),
('3dknf0uvgmvotqnkvf21578kv5nmnfts', '66.249.64.55', 1567357626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373632363b),
('d0nul6fkq3iqmkirfa7abdtcn6ssvo6a', '66.249.64.53', 1567357662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373636313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('66ia7grnvsususuho3gigtc7mrsmuqrj', '66.249.64.53', 1567357679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373637383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('v0odccumf2reg0p0f13mrvd6o5r0kev7', '66.249.64.53', 1567357698, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373639383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('8un42qbotsuh7ueiv9n123e8vjqrd1i1', '66.249.64.53', 1567357700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373730303b),
('360i0n5j0mpki1805ktl0bfu9o65bq81', '66.249.64.53', 1567357720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373731393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('r2i7vtlfv64m64v1r8raeni06qj16hde', '66.249.64.53', 1567357740, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373733393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('rlhts8d0bsdgdg6s8ifq0vojlhf80eji', '66.249.64.53', 1567357760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373736303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ic5q090sh07vgcom3vgkd50hfmjgv7t7', '66.249.64.53', 1567357780, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335373738303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('prp8hhhag7flvlrhl7l9slp57c53eq46', '66.249.64.55', 1567358421, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373335383432303b),
('jhtt5i5sphdgg2b2m5eoaial6354qle7', '66.249.64.55', 1567364059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373336343035383b),
('176eacmr3d12lrmp9tgv8enr25iidjo3', '66.249.64.53', 1567368664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373336383636343b),
('r753c99a9b88e2j8thpd65hrnbdhk7oe', '66.249.64.53', 1567369070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373336393037303b),
('phi2h5gl5kjf4drjkpbimou6afeo30d2', '66.249.64.53', 1567374445, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343434353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('kk3chp0r5kl3ch76mqhalv6jqng33u3e', '66.249.64.53', 1567374492, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343439323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('oltblt89kqs8dt4ka9g7hjnud4u41llt', '66.249.64.57', 1567374602, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343630323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fkj19hi31v0plc77s3tkghm367p2lcbl', '66.249.64.57', 1567374790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343739303b),
('asougs07h9lil40uvdbt3mp7jpg73jbf', '66.249.64.55', 1567374828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343832383b),
('9gf5r2jmqiumgr8evnd7vku663m8kcjn', '66.249.64.55', 1567374867, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343836373b),
('1faljdv84jujigma7upd6sqsmt79ppl4', '66.249.64.55', 1567374895, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343839353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('q1pt82juup4pqcp3djkso4nnu25i4bt0', '66.249.64.53', 1567374901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337343930313b),
('v6r3mmn4esi8f990v1gtm7og9sjt09t5', '66.249.64.57', 1567375168, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337353136383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ocj4npbi5vt5vncv9dj2d2l5tlvgl3jm', '66.249.64.55', 1567375743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337353734333b),
('94v9oncak4846db0t9l5osdctjngtmb1', '66.249.64.53', 1567376740, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363734303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('j966eh8ef5d7q4jggdkg9gpsqqkivsrc', '66.249.64.57', 1567376783, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363738323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('am7jvl899ul5sn8p01j3nm6p70e12hk9', '66.249.64.55', 1567376828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363832373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('0sgml2q3m8s1uas9rt5ucfqnbhnnlur4', '66.249.64.55', 1567376873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363837333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ip7rr4dl0uistpik6du5ncnf7kiqe4vh', '66.249.64.55', 1567376919, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363931383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('e0absrqvf0egt096vbjn3qu10imjepv6', '66.249.64.53', 1567376967, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373337363936363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('rmfno1a94325nc37k91982o8dqeovi7c', '66.249.64.57', 1567380900, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338303930303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('pq0dhtr445bg2o8iu5a7u7ahfm77tsdq', '66.249.64.53', 1567380924, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338303932343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('51onbasmpt306cd03rqhdpoc6b3rkfd2', '66.249.64.57', 1567380982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338303938313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('3bbo4otf7ptec0gl77u0b7o8re55olju', '66.249.64.57', 1567381239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338313233393b),
('h4l7vgk5eqobvs1eh747sfl7b7tjuhn8', '66.249.64.53', 1567381676, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338313637363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('nn5580lhem4ln6m59j6de37eiofa73v1', '66.249.64.53', 1567384179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338343137393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('pt3oial1n5mdu1lsmt2e0q348o7k9kvq', '66.249.64.57', 1567384764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338343736343b),
('2o0il0vb4tigmcmduvgan4mbi3fgc2lb', '66.249.64.57', 1567385038, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353033383b),
('kkkh89cnth1t2pffmkou7totith0b514', '66.249.64.53', 1567385311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353331313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('f7sb1emmstra8c4f122cns1fo996hrde', '66.249.64.53', 1567385324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353332333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0vb1cq2al3mcjgvonejj1259gd08vuug', '66.249.64.53', 1567385337, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353333363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('kvbop7la1rkkp0knsi3ibvigh4tus6lh', '66.249.64.53', 1567385352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353335313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ru3i9qtlra1b0rf73momb9ouaigu9750', '66.249.64.53', 1567385377, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373338353337363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('na8v0me95q4pmm3vmana7q82cfbjmqfj', '66.249.64.53', 1567391743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339313734323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('a34b3rcbm6qg1gecsn4ctk51odbsrdgt', '66.249.64.57', 1567391743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339313734333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('vs3jcnc48nrfotirq782lk816ahc707h', '66.249.64.53', 1567391957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339313935373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('cun51u2ebbo6i2q55ia3rfoibmoc8c2v', '66.249.64.55', 1567391960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339313935393b),
('cq551rr1ofi3447ltgcb35rbr2s4bhe5', '66.249.64.55', 1567392022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323032313b),
('0tmqo7ua7k2oak3l8ocb68t4qn0hbamn', '66.249.64.57', 1567392103, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323130333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('gcjn9eovrl02a488oel6v1tj4glpi8ce', '66.249.64.55', 1567392148, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323134373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('grc4oq7ql8sr7o7cqch819ebcpk4sbqc', '66.249.64.57', 1567392222, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323232323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('988m4sqt8rr35bmkhp0nm6d804iuhh3r', '66.249.64.57', 1567392303, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323330323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('p9ehtj1o95prigk479bkau2ktaol14sk', '66.249.64.53', 1567392360, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323335393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('b6hao6q8cb2ujsm0crnstn0nnb6798ba', '66.249.64.57', 1567392439, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339323433393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ulrrk5pquj749bh1o13v5aghrrf1i70d', '66.249.64.55', 1567399876, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339393837363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('bbb96b3h898sqtjskjq2ic1j1phuorc0', '66.249.64.57', 1567399935, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373339393933353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('n1rrgc8tt2tq7i39ilki66824sehbjj2', '66.249.64.53', 1567400071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303037313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fntuhfii4ueh0rvtqhn50lr8s5unvpgo', '66.249.64.55', 1567400075, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303037343b),
('4qjavdt91e9mcqse8ta6h52q5e6n4t99', '66.249.64.57', 1567400479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303437383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('nkel0if7ijcblc4ft52blu2b17vb0muv', '66.249.64.53', 1567400480, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303437383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('aq45frmk36r1jq44nqbemi9o3su5cge9', '66.249.64.57', 1567400552, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303535313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('s3dcbpd01fgin1amp8io8ehluagbs1uv', '66.249.64.55', 1567400657, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303635373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('i4hjdo1lgltjt6or1k88bs7jbo0udtu1', '66.249.64.57', 1567400755, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303735353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('flc6ivkk1bb4bitp90dde2f96nkj6ef5', '66.249.64.55', 1567400860, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430303835393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('lq5b8nj70p1r1ft3mli0jf8orpaji2l9', '66.249.64.53', 1567401436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373430313433363b),
('r4dambhp063fc4dlet8us9aegf3i6fph', '66.249.64.57', 1567420315, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303331343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('56kj8asup9r5l42f2cnavmllk1jop22l', '66.249.64.53', 1567420382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303338323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('l3rvbjhg697v4f99mtf7mrd5nnpd0fcj', '66.249.64.53', 1567420441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303434313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('38k9k8pq4gk6it2nqqo8a52hfq5fsjjl', '66.249.64.53', 1567420481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303438313b),
('f3bmutqfu722sseuai75asnjhoi4cguo', '66.249.64.53', 1567420500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303530303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('3sjlsm2ridt79eme9s39vcfqj32f3ugk', '66.249.64.53', 1567420508, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303530383b),
('bfip0dssrdrboie4ee3d6jfkndb391tt', '66.249.64.53', 1567420535, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303533353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('2de9ctm7pumpq9ja9sqactpdbaj9uk6c', '66.249.64.53', 1567420559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303533393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('les6mp39j7nftf2q01dagusm66mf75ur', '66.249.64.53', 1567420559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('6kcts98t2nqd49ur9rl3gb2aklgd5ibu', '66.249.64.53', 1567420560, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ng1c3ho3eabbb5hne1961c3b0hmijbr5', '66.249.64.53', 1567420560, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('i26hqedqjdbrniuae0ql1i7lehlr62ta', '66.249.64.53', 1567420562, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('j3kv685p72pk8o7na41ki75udva172np', '66.249.64.53', 1567420544, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('metn659ogel3q4noljtqso9ik86lgsgh', '66.249.64.53', 1567420564, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303534353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('eq1q72vkr38gk04nbcaf56047h7qa0vv', '66.249.64.57', 1567420620, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303632303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('svv62d43f3gl27iu07a6qto8j5malr2c', '66.249.64.55', 1567420621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303632313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('j1288nvlutjc67rq768tfmcn365a4hnn', '66.249.64.55', 1567420626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303632363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('nblgna3maes40od254t6g8vbub7agqdn', '66.249.64.53', 1567420648, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303634383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('epchqd5jvad9b665k0b75b6ba0688048', '66.249.64.53', 1567420677, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303637373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('usbsn2fdaaroto635778i5eqqk1onofc', '66.249.64.53', 1567420678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303637383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('fllemlef87419d2cc95e4nnp45kijpl4', '66.249.64.57', 1567420683, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303638333b),
('7t42826euratfd1vo0fnrfs0upaq18c2', '66.249.64.55', 1567420720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303732303b),
('8t4b3uupdq52jkt5vfrsoopveeag8c9a', '66.249.64.57', 1567420742, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303734323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('r43imm44tvfmqnffhm9v3rmkjnla5vr4', '66.249.64.53', 1567420750, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303734393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('f45gejb0i5r4snukcdvupcr1lv2dah3s', '66.249.64.53', 1567420756, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303735363b),
('d0uj3n1gc4c7btplns7c1v9ksgbf4jv9', '66.249.64.53', 1567420757, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303735373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('btqr2hhutk7olvs7f1l1le5spbe8l8f1', '66.249.64.53', 1567420776, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303735383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('so3a4uq9t7p0ibhfkgeebeim5tp41p2h', '66.249.64.53', 1567420776, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303735383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0r9ddt9m464kvedgfuhvnpe285ivv0tt', '66.249.64.53', 1567420777, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303735393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('d58q9r2stkmnlukj09fifj5e2r0eq6e8', '66.249.64.53', 1567420778, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303736303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('tnpvmjsgih6bu6j85qdh370qhkb8ce4g', '66.249.64.53', 1567420779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303736313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('fcruhq2r2j9s63a70iu9in01qla7g3m5', '66.249.64.53', 1567420779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303736323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('p28gu6gl4bgc4q84uqcamqnoq9e5jao9', '66.249.64.53', 1567420781, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303736343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('542bndrs4pgd6iqahngnfhj8ofvc4471', '66.249.64.53', 1567420784, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432303738343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('o25sjmeqvcbicatucedi8gal1ub4tlio', '66.249.64.55', 1567424287, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432343238373b),
('5ivudk88qeqigqrmgjf1q2lk564atkf9', '66.249.64.53', 1567425436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373432353433363b),
('8apnvnl8vtu67vn8737kkonfbmbkihon', '40.77.189.27', 1567438459, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373433383435393b),
('jn82tl5kmb4nble062rsrvfrl9skqsg1', '66.249.64.57', 1567443023, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333032313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('9u0rcaktlr5fbpq3ou55hmemmmml60tp', '66.249.64.53', 1567443033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333033333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('4jaug9952vb8kq1b1gjbuqgbjgrvqjal', '66.249.64.55', 1567443072, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333037323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ih35j4e7skerklbldf1ecm26hi69v7e5', '66.249.64.57', 1567443074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333037333b),
('kj912mv5s93tpirl0nvkmgi0vf062spl', '66.249.64.55', 1567443102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333130313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('58n08elglc4lt98bmbuputgq1k734sal', '66.249.64.53', 1567443145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333134353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('f80q8els4on8e282tmsq97gdr8qlhkt7', '66.249.64.57', 1567443193, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333139333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('u5rpunujr02ar348t1qbmqm3s27vg6dq', '66.249.64.53', 1567443247, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333234373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hpao349u8hfebm9dfmpe6luf0mt34vgc', '66.249.64.57', 1567443310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333331303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('fel8au0seqqq8tfqg57dfc644s3hnbtg', '66.249.64.57', 1567443389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333338393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('s9m48r3e8lvp1r1th9b93p4jhcdnn9h0', '66.249.64.55', 1567443569, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434333536383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('jcu0t92v4ohoajsgo0dbljko9fo56ic8', '66.249.64.53', 1567444795, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434343739353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('8j17se896ch2mgu1aqftifrtsuj7b4e6', '66.249.64.53', 1567445367, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353336373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('lbg5d6kjvte12t8a2le0cvmou6cmca67', '66.249.64.55', 1567445493, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353439333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('rgaqeipq2jedtre8ag3k30n44iinc8ua', '66.249.64.53', 1567445504, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353530343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('rl3b1doit3j059hiop2o9g4funl0ohp9', '66.249.64.53', 1567445514, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353531343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('p1n8vv7b47259gs9oaql9jdutvc4nqa1', '66.249.64.57', 1567445596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353539363b),
('r6jl1h2jirrd51idq5hnf1p7cqc5rsd8', '66.249.64.55', 1567445641, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353634313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('jqeor1o74hu1vtoibbms6psjc11alrbq', '66.249.64.55', 1567445689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353638383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('m6prql41356tep0j5pa3mhulpmi8ojvc', '66.249.64.57', 1567445736, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353733363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ti3je8bevn6n9vn5lim1o4i80afbk891', '66.249.64.57', 1567445788, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353738373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('pakehj0oufrndvmth481k7vc8gk7qk4c', '66.249.64.53', 1567445808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353830383b),
('5bu5c8kpot1bc629op5emgha3di6mq35', '66.249.64.55', 1567445828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353832383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('uepb74muu3cnn0591q2nobdjfin7cep5', '66.249.64.53', 1567445869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353836393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('c3cj3c0ca89t6bs88mn8kkoh33dh82k9', '66.249.64.57', 1567445909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353930393b),
('hqkk3tiorgbc9fucmeudjfeopef60cv3', '66.249.64.53', 1567445929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353932393b),
('vfrma3bun95bjkmal962j1saleh1l3q4', '66.249.64.57', 1567445966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353936353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('uo7n4k8k3rfuro8njr64rsdi7i2rkgcd', '66.249.64.55', 1567445969, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353936393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('mpiosmag29ijc9jgsfkr4r3ql3j6gv68', '66.249.64.55', 1567445973, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353937323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ou0u08k99f6i25af8d8113na9lmaaihu', '66.249.64.55', 1567445977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353937363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('u4b4qtg428ri91f8qv63h6eahj5cm3cd', '66.249.64.53', 1567445980, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353937393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ik7trgk9ebs1en1keokvqqkue95gaosq', '66.249.64.53', 1567445982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353938313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('ljdi53i56cm97qe1t2p4bkdopsa9dja1', '66.249.64.53', 1567445984, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353938333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('qku6gepgheb1ur0je8rbahff0p11hoas', '66.249.64.53', 1567445986, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353938353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('jmgh941ku2eu05634d8kbh9rcabk8djk', '66.249.64.53', 1567445988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353938373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('g7ueip5t3mdirga8j0ld83rae8190qa0', '66.249.64.53', 1567445990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353939303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vbhsib2lcl0fptkmrcn5sbi2fcm6ug0n', '66.249.64.53', 1567445995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434353939343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('1cocl5eh7gdip9ohun6u40vfnes4551t', '66.249.64.53', 1567447741, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434373734313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ejlu8qvvmai01i2injk8f0nf3or0g9it', '66.249.64.53', 1567448140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434383134303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('9740me5v90itqtjjc4tjun43ujfbonkf', '66.249.64.57', 1567449332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434393333323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('70ob0s6eu2jhu5p2ku3mtkgg0llbn3ek', '66.249.64.57', 1567449621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434393632313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('b4ufne1pqpjhi52tlrpqhaho36e6adv7', '66.249.64.55', 1567449636, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434393633363b),
('1htejpctc948prq0pa7gnr09uk5a9bbq', '66.249.64.57', 1567449876, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373434393837363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('k3vubaofddjp3uhd0mv2a85e1qdf85va', '207.46.13.104', 1567452074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435323037343b),
('9lfkun2judk2eb67mqh3chkntiggbvq1', '66.249.64.57', 1567455692, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435353639323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('osb6jasudsjfvjgc9hbpet1aevree6pk', '207.46.13.148', 1567455760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435353735393b),
('r890h2qnnjtt27ggfg7lkrmh8mvtokpl', '66.249.64.57', 1567456314, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435363331343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('vepevbv7p0ek2o52sr1k2r2sgp79sb3a', '66.249.64.55', 1567457467, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435373436363b),
('j740gtdv8a788t70gs1t3gmvalepcseu', '66.249.64.53', 1567458070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383036393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('21thbeutdg0csojl0d790qjgvuead2js', '66.249.64.53', 1567458113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383131333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('7l5fnudtp28l36ue1gr0obdvkog3k4ov', '66.249.64.55', 1567458163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383136323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ka4op4v3nu207mlkunp51imu0jsk7mqd', '66.249.64.55', 1567458219, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383231383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('3fn7on1tos0idognkdg1jt3plb9t186c', '66.249.64.53', 1567458284, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383238333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('mhrsft97q1qajaf9red4uhthusqo7re2', '66.249.64.57', 1567458402, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383430313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('6f44jpj8g7bvh03kscmu2rii8au5v4om', '66.249.64.53', 1567458550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383535303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('hrr60ju67vps2hk5o9gv1iom818041tf', '66.249.64.55', 1567459141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435393134313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('f8qi4figepu6haat3dlrhhk7ssrhlknr', '45.58.142.29', 1567459145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435393134353b),
('6c629nngn7br0k9c1iusvhvrip984v2o', '66.249.64.57', 1567459145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435393134343b637074636f64657c733a343a2247374b35223b),
('ut9r06lhvnba5amvqdjbvu79aqk6ajoc', '45.58.142.29', 1567459656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435393635363b),
('v2a6894u7cbjn1s8kpnqej8lo2ohqgf7', '66.249.64.57', 1567459656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435393635363b637074636f64657c733a343a2258334644223b),
('3l49jfbt00ipicp4kha6ss4vjdhgbksr', '66.249.64.55', 1567461138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436313133383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vndg82afv2t423mlg6pbo6f80r2316t7', '66.249.64.53', 1567461142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436313134323b),
('ua48sfpdb88jid0503rmn0urds0i7ubt', '66.249.64.53', 1567461439, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436313433393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('u7h9bbsvv9nlehu8lvl437bolnpd8vd8', '66.249.64.53', 1567462624, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323632343b),
('23cddrp1diaucjvcmlhb5lgvjt97cs04', '66.249.64.55', 1567462721, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323732303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('i5t7snoqe6e6e2msni27trom5b0lp016', '66.249.64.55', 1567462728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323732373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('r5tc6fvba4rlbvquima7b6lpus0p4t74', '66.249.64.53', 1567462736, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323733353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('gpte3s7bis2ep0bmdhv26nqpcrlitsiq', '66.249.64.53', 1567462745, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323734343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('t1v4k3tm19tcaa2a69j5omdhoi8jds3l', '66.249.64.53', 1567462756, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323735363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('iadn88i8dnjasq5hseu0idp0kb217sv9', '66.249.64.53', 1567462779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323737383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('v5btc7phnh0l0ab9qbmp8gei790rtvbc', '66.249.64.53', 1567462797, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436323739373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('30ucrg53qacm8pud60o5d6d2v73uv309', '66.249.64.55', 1567465887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436353838373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('nvo2snr56jpusp1p4tmsrpr5mnvpmeq2', '66.249.64.55', 1567466991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436363939303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('vf9tglcmel3cnte573isqoj0bnnbokbt', '66.249.64.57', 1567467381, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436373338313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('kuhh7rk7cnd8ecnen7fhs19k7bmi69le', '66.249.64.55', 1567467605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436373630353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('al2cbob9k0ipdgv7cfs51uj5uejldbi7', '66.249.64.53', 1567467610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436373630393b),
('jpibalrohls76hbm9jh05v1dpdsviu9k', '45.58.142.29', 1567467866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436373836363b),
('sji82doc7sftvh8j33rhtppnlps7jcp3', '66.249.64.55', 1567467866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436373836353b636170576f72647c4e3b),
('5vhe9us8ua67p4ap6c9fad4042i5i3te', '45.58.142.29', 1567468510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383531303b),
('t1ddt7lbbaioaphojrb2qp88tcmbbmcj', '66.249.64.55', 1567468510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383530393b637074636f64657c733a343a2258334644223b),
('n8jtephvvouq2b9p3nelak7j4eceq74s', '66.249.64.53', 1567468570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383536393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2254394c34223b),
('bbggce6o99i9qorrldhp9pavqi9pnmum', '45.58.142.29', 1567468570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383537303b),
('b09n9rj587t9mc71ku81sq4dikpvtnns', '66.249.64.53', 1567468597, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383539353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34333a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d3132363f73633d796573223b),
('ic47gb8tuo0gnol01flj68mf2v0mglcd', '66.249.64.57', 1567468626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383632363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2247374b35223b),
('oine1fmoihae5eb48u6q7sdm6atac427', '45.58.142.29', 1567468626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383632363b),
('r7v5d3f411ii7r387pdeeom17h8e2okc', '66.249.64.55', 1567468656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383635353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d6a62762d313236223b),
('ssvf7b374fekih3e24ts3d64k7n09lst', '66.249.64.53', 1567468680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383637393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('9bh7poj7306j4ljtijen2ajlok3h9439', '45.58.142.29', 1567468680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383638303b),
('ln532bhr72j11gt1ls2ji1p800b1lhk3', '66.249.64.53', 1567468706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383730353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a224e325735223b),
('p1c2msqgts2li354kpp6ecr80vr3u9cb', '45.58.142.29', 1567468706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383730363b),
('jfblem0875c2aip0bqtvs8qrokr25iqr', '66.249.64.53', 1567468732, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383733313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2258334644223b),
('na0p298iifua3p0kb4320ddqi5lgktjd', '45.58.142.29', 1567468732, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383733323b),
('iui3cmcdk2k8hlpekao0fgokld2g9n9d', '66.249.64.53', 1567468759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383735383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('njo0lmi09mvrdbnk8sokjdhjri0c820m', '45.58.142.29', 1567468759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383735393b),
('0g5pdmlinq6sa4806cu7s68iod8fo48r', '66.249.64.53', 1567468766, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383736363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('vlhgroqntmvsh9hpnsrqpblbvmppi1hb', '66.249.64.53', 1567468785, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383738343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('d778rchk60gh0q5l3fas0j9jfv57p0rf', '45.58.142.29', 1567468785, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373436383738353b),
('ir0cg6jme38b2ujbivtff80ttm6oal7c', '45.58.142.29', 1567470434, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303433343b),
('u2gjm581pp9tnh1crkfjrsrnv5rfekr2', '66.249.64.53', 1567470434, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303433333b637074636f64657c733a343a2242345738223b),
('cufokorba18hm97k077c8d5lr0rr835u', '66.249.64.53', 1567470481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303438313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35343a226a6f62732f747261766f732d61622d313532383339323639382d6a6f62732d696e2d736f6c6e612d68616e646c65646172652d313531223b),
('51u4snl8hsfl8mp632o4ideok9p7sreg', '66.249.64.53', 1567470488, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303438373b),
('2de99rd5k1q3telep5868u4ctp1gn3da', '66.249.64.53', 1567470495, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303439353b),
('m2knl5hpe8c4o7h0mici2flukvv76mta', '66.249.64.53', 1567470503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303530333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('mkptr718q3qgbgttl0412o0vtlp3rc3i', '45.58.142.29', 1567470503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303530333b),
('iq98as5g77qa00he55o747k0gtelgseu', '66.249.64.53', 1567470511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303531313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a36313a226a6f62732f747261766f732d61622d313532383339323639382d6a6f62732d696e2d736f6c6e612d68616e646c65646172652d3135313f73633d796573223b),
('jdv8bbk4o710dv6ig5m2cu4ppejgh0m1', '66.249.64.53', 1567470521, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303532303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('5sc285retq5thinqhak4er3v97rgsddr', '45.58.142.29', 1567470521, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303532313b),
('85eumkrhhc5450c6ur4u29n92k9a45pt', '66.249.64.53', 1567470537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303533363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a224e325735223b),
('hkopa4eunabt52d72pg05e1masfn6tn6', '45.58.142.29', 1567470537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303533373b),
('9fs8l679c9cg7lta0jd31vdn28uh1vse', '66.249.64.53', 1567470549, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303534383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2254394c34223b),
('9ah0cchg85rakevkehbqu7tfc4rea7uj', '45.58.142.29', 1567470549, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303534393b),
('d50o4niqlboqql83cvv30918fmjuiu0n', '66.249.64.55', 1567470555, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303535353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('c3tedso4o83orl2i3vns6nt3gcok2fio', '66.249.64.53', 1567470561, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303536303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('e6rbpk6kb63o193lg72ajifbn7itd21n', '66.249.64.53', 1567470564, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303536343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('6afhofl6udc02p9v0k9luvt6fe9466kb', '66.249.64.53', 1567470568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303536383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a224e325735223b),
('v7qmoo0ol22qcjdgs04ppd9vshu8rbgr', '45.58.142.29', 1567470568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303536383b),
('e39gqkvnh3u3f4bvu83ivon4ei2fntg4', '66.249.64.53', 1567470572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303537313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('dknse0m31i4vajduaejmlj7p476n7dkc', '66.249.64.53', 1567470576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303537353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('eta0fhm1l68feumcja8ql2ke9mt50ijc', '66.249.64.53', 1567470579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303537393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a224e325735223b),
('h0r5kumlli715oqp9ojfujrkp8hq465c', '45.58.142.29', 1567470579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303537393b),
('rpbjvn4q3tdqpi6kq27c4rss131jv35k', '66.249.64.53', 1567470583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303538323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('868rig344k80sia5ttqpalgji9hddkk8', '66.249.64.53', 1567470587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303538363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vragap9qms1ikuhjkftml8stgba4ai0p', '66.249.64.53', 1567470591, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303539303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('5bb68jmarfqg5iro6iv2osee4lq1vsi5', '66.249.64.53', 1567470594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303539343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('mto0hdikc1275gjkagec0nponn7sevn2', '66.249.64.53', 1567470598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303539383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2242345738223b),
('mbq242d5pc9qg4fu6ui4fm0lhbshmnsp', '45.58.142.29', 1567470598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437303539383b),
('rdqmqoteg051rmcnia0j6qd2cq14qrrr', '66.249.64.55', 1567471151, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437313135313b),
('1nbk17qh5as3esgnqguj062c8ivjn4c8', '66.249.64.55', 1567472786, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437323738363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('grj087edn5a7kba06l0fepj09791mnd3', '66.249.64.55', 1567473925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437333932353b),
('lcuf0n48pepsr7v725bjlrd7u07qnrv5', '66.249.64.57', 1567474130, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437343133303b),
('q8h0dg0brg71bu1dcop3ntlmot15efe3', '66.249.64.55', 1567474327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437343332363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('5k8tdjhs5su4vtclt43k8asngsavblar', '66.249.64.57', 1567474572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437343537323b),
('kplvibf28dn0muiu83m1veun736arto3', '66.249.64.53', 1567479953, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373437393935323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('c97cji8nlit0lj75uo8m0mu1a688gtpt', '66.249.64.55', 1567480149, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438303134393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ckisaf3phlc98i20nup48ma7iqacj2f6', '66.249.64.53', 1567482582, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438323538323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('vtm1cbjtj4fc5nlvndboglbi6532dqf8', '45.58.142.29', 1567482585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438323538353b),
('23srde82kj384lmusf3bnr8k1qf0vlkt', '66.249.64.53', 1567482585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438323538343b636170576f72647c4e3b),
('r977uq4sdbutipa7k2bt483g62s5hhou', '66.249.64.55', 1567483012, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333031323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('q2aiholp8mundurb5v6oai58jr51g7at', '66.249.64.55', 1567483020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333032303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('h1kh8ff1ig0p6cbnnj1101rqmpf9n0j3', '66.249.64.57', 1567483161, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333136313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('tok1vi4a528a7jeqhckhjrbp6ha25keh', '66.249.64.55', 1567483166, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333136353b),
('r0ig995cbvrjeevauv5v13aofufftbnh', '66.249.64.53', 1567483172, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333137323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ejr6phppck7jdcpnq0kv4bbsdr2959vf', '66.249.64.53', 1567483175, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333137353b),
('mnd4bjsdkqcmt5vf0bgs9o0bv2sodeb8', '66.249.64.53', 1567483224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333232343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5tp7om1t46j305qj9sg3n3a0fh8b0fiu', '66.249.64.55', 1567483243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333234323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('n3qamkh46c0hbc2dpgqvt84i0r7986fn', '66.249.64.53', 1567483245, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333234333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('i650sbsueahna7uhe24vn2j29nm2digr', '66.249.64.57', 1567483246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333234343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hqr08jtjqmn2jdk999s4v35hur7cr12h', '66.249.64.53', 1567483247, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333234353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('1m5n6jlng65n41k8eponqqhosu16ioat', '66.249.64.55', 1567483248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333234373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('k1r2u87dvjk716pf4adj5pth8jauednc', '66.249.64.55', 1567483400, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333430303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ukemgo1i3lb578edeie25lclusenvpuo', '66.249.64.55', 1567483615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333631343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('qeimud24diuso5t79unmi6iklc92g614', '66.249.64.57', 1567483737, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333733363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0g7do1r5f5i6pdg9afak2oj24du1og1k', '66.249.64.53', 1567483756, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333735363b),
('s3g0q1pltsa975ev9j4msss99f7oaqov', '66.249.64.55', 1567483950, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438333935303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('an2tv3e1p1lllp9qj2jjoin21hrdrdv8', '66.249.64.55', 1567484125, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438343132353b736974655f6c616e677c733a323a224172223b646972656374696f6e7c733a333a2272746c223b),
('ih6lrq39tn497aldqca0mqfaokfsmqun', '66.249.64.53', 1567484466, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438343436353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bsd5vb4m3lirkog7o3fifvbsu94b3j5r', '66.249.64.57', 1567489347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438393334373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('djklb3te5bi9g250el2k56cd0h4a1ev2', '66.249.64.53', 1567489666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438393636363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('l1jl6u92hnmjdu9a66oh6bcm70rn4t0b', '66.249.64.55', 1567489668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438393636383b),
('55apnkcpe40p8nh1qkv4eu168t07ooq4', '66.249.64.55', 1567490525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439303532353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ip1pbtuo6m4jms1qikpuvk83ehcgd1lo', '66.249.64.57', 1567491015, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313031353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('lea7qd33th58mtjpsjmuh29f5g3dmi8o', '66.249.64.53', 1567491028, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313032383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ddmtn9l7cun3f60vr7v3p6phkd5u39pl', '66.249.64.57', 1567491083, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313038333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('4rgdfhof3dj8eql1o7blj90go4bf4n4v', '66.249.64.55', 1567491088, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313038383b),
('ngeb4fvt5ep8gpv2as5bmgtvjstaegv8', '66.249.64.53', 1567491104, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313130343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('75033et9huq7fd0jkjqumu3bdm4fee04', '66.249.64.53', 1567491115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313131353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('qpa45i1c3374ciiaol207l1k0va2kf4c', '66.249.64.55', 1567491126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313132353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('j62p39nn1usdk1ilgqoi6qhah5550hh7', '66.249.64.53', 1567491126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313132363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hu45e4m2i8bklbdrknefbar6aerhn4jh', '66.249.64.55', 1567491328, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313132393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('g82qj76ia0687i1e9e88tv9d5iomtc0g', '66.249.64.53', 1567491133, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313133333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('i2vep79hjc01bup516i78pqa378d74f3', '66.249.64.53', 1567491139, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313133393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('69et6ghdusedovf57f1qi67rnbi903i3', '66.249.64.53', 1567491143, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313134313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2258334644223b),
('a6lu0rl12m1a6omanklgevsiu9dnqkcv', '45.58.142.29', 1567491142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313134323b),
('2ginaahdiuolcfh296k5sf33kg47ud1k', '66.249.64.53', 1567491144, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313134333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b637074636f64657c733a343a2258334644223b),
('n55rpv4pju3fs06178qmm18bdkqbnvn8', '45.58.142.29', 1567491144, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313134343b),
('6anuafeml98efo7tmh6i90vbv5crujt7', '66.249.64.53', 1567491150, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313135303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('95ldfsrtishehnftojt9vqh3f7b6koc3', '66.249.64.53', 1567491153, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313135333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('emgnq005o86rbutgoru8sp322fhctj2s', '45.58.142.29', 1567491156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313135363b),
('er3a9t44m42ri7488evnc4aal60pdehf', '66.249.64.53', 1567491156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313135363b637074636f64657c733a343a2247374b35223b),
('ffi9t7qbe8opbl47p79ra6dfrn05ic56', '66.249.64.53', 1567491160, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313136303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('09j0onfdn40lnh840r68f5hlci7glm3a', '66.249.64.53', 1567491162, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313136323b),
('gpacm5t1o67mivb5iknrk88r080fkkfe', '66.249.64.53', 1567491167, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313136363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('j1ve5fnvn6bkasj3k1j1meecbkk48o0c', '66.249.64.53', 1567491173, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313137313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('q58ncr1h601t6aeik6bsa2cq6np1b8jm', '66.249.64.53', 1567491174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313137343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('r62prt9u0n50ila99rgv5bl51sdomm9t', '66.249.64.53', 1567491176, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313137353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('6q14rf2i5l00ks2a9ju3lue263f9sr9a', '66.249.64.53', 1567491180, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313137393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('uk41licvq9p2prhp38fceenkci3j9qg8', '66.249.64.53', 1567491181, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('r8lkevnme3vpcupuldgp91skt3nfdhe0', '66.249.64.53', 1567491184, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a2242345738223b),
('df5vg2ihtqll9di899ch7d3iju2oqr4r', '45.58.142.29', 1567491184, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138343b),
('tbmg468s0eivkh3qujqra00vnou852se', '66.249.64.53', 1567491188, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0kufq2rcra114035i2tjhnoamp9p96f5', '66.249.64.53', 1567491189, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2247374b35223b),
('2u3roc9jspsn3f9ergcbs826cvq56u1s', '45.58.142.29', 1567491189, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313138393b),
('9nu5tr0kc6f67q285oai39qvaqas618b', '66.249.64.53', 1567491191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313139303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('mgq5de9igrjj4skj9bt4v19ib8ti7vsr', '66.249.64.53', 1567491194, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313139343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('bobl9v15roin6m2n4qs9fdfvnhl83l8t', '66.249.64.53', 1567491198, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313139373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vud5fahb0m0u4oh1soof7933ns7nrqfd', '66.249.64.53', 1567491202, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313230323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('lc5ujh77q5f45amhjsmm5t6fl9ptsftl', '66.249.64.53', 1567491206, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313230363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('uuvdqm9t344clu9j7t0vph657hfrfh96', '66.249.64.53', 1567491210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313230393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('f3tusocas0sc0ka18sivb8vcppve6q3q', '66.249.64.53', 1567491214, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313231333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('8t3k2loban9a8h632uurfjf34lmvpjbm', '66.249.64.53', 1567491217, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313231373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('bpkrvesijkbgp6gqvoj4f73a896abh5q', '66.249.64.53', 1567491223, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313232323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ckn9gibdtaquhpnf4g23lp5u56erehf4', '66.249.64.53', 1567491226, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313232353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('qb5abgodrllubvhjmuc7l01k127fl54g', '66.249.64.53', 1567491229, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313232383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0mltbea65ua0ogq0ubc0uki5mtc0o47o', '66.249.64.53', 1567491232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313233323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('3osfnuptqkjucoe1sgvd8gmg0m0vrmsb', '66.249.64.53', 1567491236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313233353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('fahk07674a61t3340ektks5dlc207tng', '66.249.64.53', 1567491239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313233393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('tbma0773galle4osabavehjrf2lj0lmm', '66.249.64.53', 1567491244, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313234343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('ern1c5q8qbktden5465ullhl3elfspag', '66.249.64.53', 1567491249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313234383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('5c3rbsfdj3brvjgun56safi2l5m6jrjl', '66.249.64.53', 1567491251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313235313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('p63sl5hfhc4i441vhtkevklnehmbsqc2', '66.249.64.53', 1567491254, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313235343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('qm9jthvqqgn5r7vs7ejgqnjfau0nv1oo', '66.249.64.53', 1567491261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313236303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('tct4nidf0jejvtf1mopvuu9pr2i01u3d', '66.249.64.53', 1567491264, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313236333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('4mvsh4l8nqocvbi4hd6q34t1abecl3fk', '66.249.64.53', 1567491266, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313236363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('4eef90btvte2fnra1ds4r8d4j4uklpg2', '66.249.64.53', 1567491270, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313236393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('e859f8goka79lnmdn11bv6r0rv4b2dj2', '66.249.64.53', 1567491273, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313237333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('l30sh0n890jeqle42h5t99h2unqeicga', '66.249.64.53', 1567491277, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313237373b),
('33pphavouiclqqfmuettum4uncnrpju9', '66.249.64.53', 1567491283, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313238323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('4khg6qqeaapsfbva2ck15cm2gtuf0pn2', '66.249.64.53', 1567491288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313238383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('auf8pkjf07vkcu13ka0p9gegsf0kc9hc', '66.249.64.53', 1567491292, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313239323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('dh8e1hflue7gj40dgs3p28gsc4dg5cro', '66.249.64.53', 1567491295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313239353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('stc0vsesvsv8bh8qper9rsufluufujbo', '66.249.64.53', 1567491300, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313239393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('4ofuf35ph11ii9uchopsno3n6i44so3f', '66.249.64.53', 1567491302, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313330323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ke1kot4jf65r3jpnnrjrjktqu5dhb13s', '66.249.64.53', 1567491306, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313330353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('oreeh8a4n0ks4sq19m6lu2blnebck06v', '66.249.64.53', 1567491308, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313330383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('gtp39gblg7pfbd3bkd5t5p7ipk534g2r', '66.249.64.53', 1567491310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313331303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('q87jr415kjgnoc506h3v10n5c0eat630', '66.249.64.53', 1567491331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313333303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2254394c34223b),
('v7h1humchqe1g6e0ddtmhp68hvu9p2c1', '45.58.142.29', 1567491331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313333313b),
('8ekgubmk3t9fhmpb9n3bs6l60qpctdu6', '66.249.64.53', 1567491338, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313333373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ccvjr47lonrt9ue6mcc5ihkskcld0vib', '66.249.64.53', 1567491341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313334303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('cgk5e9c1ll26jc793r7ignamnsi8nn88', '66.249.64.53', 1567491345, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313334353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('pdtog5d9gm03utgqtt62ndbli9bies6a', '66.249.64.53', 1567491347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313334373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('bq05i2l2kf4cbrs06ai3nbgk6vbqn8np', '66.249.64.53', 1567491350, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313335303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('eg1ui2lji7uhfdmrm1phb2ticcp43rko', '66.249.64.53', 1567491356, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313335363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('b3eva52il2aav9o68iaocapdov5kdvus', '66.249.64.53', 1567491359, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313335393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a2258334644223b),
('4s4ih25iejs9hpi2rerl6ff62kjv8cu3', '45.58.142.29', 1567491359, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313335393b),
('b861djhcsph2suahbtaeaicbpagen6ou', '66.249.64.55', 1567491367, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313336373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('p0u7231kok40bi011cd49c51aic16l1g', '66.249.64.53', 1567491376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313337353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('7cv0fqq92gji7btdcg50mv0paujru9i0', '66.249.64.55', 1567491379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313337383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('bnd222c4leb6hv6rcmoridl4cqt4pp54', '66.249.64.53', 1567491382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313338313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b637074636f64657c733a343a224e325735223b),
('ob1lupao4lhbbgbem5chehgg9oosr6te', '45.58.142.29', 1567491382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313338323b),
('1q0jqm93b80u75r6i6n2i6evkgn9lspa', '66.249.64.53', 1567491385, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313338343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('87j1dugcj59ojjb7l0em9s7suspgjtuo', '66.249.64.53', 1567491390, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313338393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('22dtqetons5upvg9jrb40dvgvbmge19f', '66.249.64.53', 1567491394, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313339333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('r1v9inftudbigucqmppu9id28t17a18f', '66.249.64.53', 1567491395, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313339353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('r159jdkv1m358kc9tioctbmgvfls1rv7', '66.249.64.53', 1567491397, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313339373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('lclb6155peoisb4jqi1ej3ae5cr9mu5h', '66.249.64.53', 1567491406, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313430353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b637074636f64657c733a343a224e325735223b),
('c00suvj5cf648fakpal8c0mh6ktfto25', '45.58.142.29', 1567491405, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313430353b),
('olkj1rb7nit9tc36cc7ifks14m5teefl', '66.249.64.53', 1567491407, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313430373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fp2fi17rc6a9kl3bj6r8qeesni03t7ap', '66.249.64.53', 1567491412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313431313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('0ko0vlqs32a8q76m77c93scrifoaqqd1', '66.249.64.53', 1567491413, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313431323b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('6fqvbr9blili351e2ikr96va0f2uikf5', '66.249.64.53', 1567491415, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313431353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('ohgt5p11s1chme6e8aevoog3f5mc5bh0', '66.249.64.53', 1567491418, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313431373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('odd84a7j2sdvs2ni89q6d7vqlllhec3u', '66.249.64.53', 1567491420, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313432303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('2hsdc9eme0mmdf60oejq8rd0p4l55q9s', '66.249.64.53', 1567491422, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313432323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ij4e2janbr3qvij0b8qmhsm5bh96jio6', '66.249.64.53', 1567491424, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313432343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('719gp6fqdb62budnn0o3273p89g1fdfd', '66.249.64.53', 1567491425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313432353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('16gvd4m79oas0j6uu8v5234mqv8ooifd', '66.249.64.53', 1567491428, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313432383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('kobuuifv5p4q2p0kvgk31nis54d9g6ul', '66.249.64.53', 1567491432, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313433323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('8duj64m2dgvuive225smovbid16ltlok', '66.249.64.53', 1567491435, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313433343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('80ej8tqj5roaohklaqlkd6karioskpoq', '66.249.64.53', 1567491438, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313433373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('kc0q5i4lmv9qtcr606tinmsbg8uk3920', '66.249.64.53', 1567491441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313434303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('e4bvh29sqlfuvi7gmdafj904entlj6s7', '66.249.64.53', 1567491442, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313434313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32363a2263616e6469646174652f36323539343635663364363735303231223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('j0dgilb6dbkqpekssn23e3hmtp6v9g5a', '66.249.64.53', 1567491444, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313434333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('e8nnrv11fusc2qlhicfs8aeiv9vfqn6h', '66.249.64.53', 1567491450, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313434393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('7hk8pjdb2ck352us6qbflfrmuftkofdu', '66.249.64.53', 1567491452, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313435313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('d7ujlsajonmaf62euc9c88ct63nnqu8j', '66.249.64.53', 1567491453, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313435323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('7dqu6qsmhqtebp4m4sq53f4lg9j7jvap', '66.249.64.53', 1567491454, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313435343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('gfp4q582ild1n2f7n2sfo8tafnf7huta', '66.249.64.53', 1567491456, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313435353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('5nfj6qj3crka0m4rhcsj040i7462i345', '66.249.64.53', 1567491458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313435373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('54i6g83t84801o54s5orn5898crjq1co', '66.249.64.53', 1567491461, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('irana1rilqa0n7encb0o61otgaggq8vm', '66.249.64.53', 1567491462, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('79pvt2687v69fc1g34acbabt8vnm2rbg', '66.249.64.53', 1567491463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('2i63nee8k436qobc265jpo095o398626', '66.249.64.53', 1567491465, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('295ml5cbmav2h2re280i44ccl8hp2lur', '66.249.64.53', 1567491467, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('mfhebd7ooj16osnnm1bfkoaigvb3spo5', '66.249.64.53', 1567491468, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313436383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('fedn9p6hdqlecpesbdjrffv872muto03', '66.249.64.53', 1567491471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313437313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('320mtcn34l9j0d1du4jtq9b2h61cpand', '66.249.64.53', 1567491472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313437323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('h3j4f6omkne3id8jiulvdfihgrnc4o83', '66.249.64.53', 1567491475, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313437343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('79m1osdhsjslt04n5jful62bajaiqpmd', '66.249.64.53', 1567491479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313437383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('mkgrklsj8tl4lvgs7f8ojpdkrjt1a892', '66.249.64.57', 1567491483, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313438323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('qdmm0n164omo3hb9mk5khul6r6ace92g', '66.249.64.55', 1567491486, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313438353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('mv1bn4183t55kd7d3vn1irva87rnk840', '66.249.64.53', 1567491491, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313439303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('nhitkjbs2o99a7h0ehu7d4o1g7pbfki7', '66.249.64.55', 1567491494, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313439333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('br901q6lqvirm4i0gs17dd7t9ktau1j2', '66.249.64.53', 1567491497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313439363b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('i50n1gqm07ksvpnc69m8cl4lqlfq3ah1', '66.249.64.53', 1567491500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313439393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('dmqmuftej9f4dtlrph301aces9fo6v0c', '66.249.64.53', 1567491503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313530333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('rkpgcg8vtf8a5tq2spqjfjsfm5bur60o', '66.249.64.53', 1567491505, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313530353b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('7jondjkne5ep3tahfbqic16vcm8238s1', '66.249.64.53', 1567491508, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313530383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('eopfb097l9d6liraovj4tuee4pkddosa', '66.249.64.53', 1567491511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313531313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('h1f9f910vf7p3r6s38v8hojg293gdt46', '66.249.64.53', 1567491513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313531333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('h88a5dft8j9mh3shhdu9ljv8akbl2v2i', '66.249.64.53', 1567491519, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313531393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('2t3kgafdpqnde1183moi5lhc3g90t7pi', '66.249.64.53', 1567491521, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313532303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('3vb0ur8tik2u3hgr81p0tdcsqpr2kmsc', '66.249.64.53', 1567491522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313532323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('idq4chj0rc8gkta94joqei7o40qo3ne9', '66.249.64.53', 1567491525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313532353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('5o75qf3k5o39hf6glle1p25e36r5tptj', '66.249.64.53', 1567491526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313532363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('skot5t29fpo483ouarbk28egb7oiv0m1', '66.249.64.53', 1567491528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313532383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('csfa6b9669ipk0vpkd54al393a75bjnu', '66.249.64.53', 1567491531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313533303b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('0490d475blbtioqd26is4l0i1k271dsd', '66.249.64.53', 1567491534, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313533333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('nf9sm4s3vosusdpp5tvreernadhdk5ro', '66.249.64.53', 1567491537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313533353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('jubkh0717qdclohtnqevp8ksudqlkjo6', '66.249.64.53', 1567491538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313533383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('bd18j5mtb1m3dtq9pn242tnb57oh9dki', '66.249.64.53', 1567491539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313533393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('pg7uvf38gmearfc6kgrbij3p9b96pi8c', '66.249.64.55', 1567491541, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313534313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('slle1cvg92v918ebalmkcd20ldtbou1g', '66.249.64.55', 1567491544, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313534343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('dd82tsomfd4rae85ifprdudauru6bdbt', '66.249.64.53', 1567491545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313534353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('cb449amuknrmq4gooeb5fha46gl5lnh2', '66.249.64.53', 1567491547, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313534373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('qvupm74qb67tb3e1sjh19ofirfbs0daj', '66.249.64.55', 1567491550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313534393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('657drv2vpb3vhs7sljho7mkp6c5sb2rj', '66.249.64.53', 1567491551, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313535303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('8uu116g26dmrq722el9iuc05kmq1mcqb', '66.249.64.53', 1567491554, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313535333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ouv01ramt27hdv01edn6q65nc799ilon', '66.249.64.53', 1567491556, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313535363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('hpmukbnca7j1mudn44jfa2et0j99r1te', '66.249.64.53', 1567491559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313535383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('sjf2rs2emj9e0gt7pb0s2029aqvaaih1', '66.249.64.53', 1567491561, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313536303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('ne63595le0qlum0plvijovo960bv88hl', '66.249.64.53', 1567491562, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313536313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('8nheq9g495ur2gbdu5mejagcrsh9hjh9', '66.249.64.53', 1567491564, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313536343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('lqrdjbs7pd3k4r9tf90n20950ba8cvug', '66.249.64.53', 1567491569, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313536383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('10sjg0nfldsa8jvq46ipjhauiumu9sqj', '66.249.64.53', 1567491570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('r97ijqgt53a21255c2bqeira11hanall', '66.249.64.53', 1567491572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('3j9r8g3u26c0bnaqa2fnn6ridp6d0ge8', '66.249.64.53', 1567491574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('lfmhv1im9l4drpp3nge9bhf3336ud3ua', '66.249.64.53', 1567491575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('k326835o1qn7gqv4jo4ot1il9kp1c1a6', '66.249.64.53', 1567491576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('eeiicenpii21dag69ifmd61hh6dnf06v', '66.249.64.53', 1567491577, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('5uam5hdjid8arnl8gbolu5stcgu6qaef', '66.249.64.53', 1567491579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313537393b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fnbgoithvarg1sqv63r8h43ikgkpjmud', '66.249.64.53', 1567491581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313538313b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('6if0rdanmlot61k7g2oq780cuvoja5fi', '66.249.64.53', 1567491584, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313538333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('8ndporjbu07thi683a6pjud4ikcfm6et', '66.249.64.53', 1567491586, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313538353b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('o4r57s6n18nhp8b31brr82d8kabsnb04', '66.249.64.53', 1567491587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313538363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('qishcg8cu5irmfuehcchupr2ti57scec', '66.249.64.53', 1567491588, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313538373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('ieevoeo45oatms8kuqdgn6gtadg25jvm', '66.249.64.53', 1567491591, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313539313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('gmtcu69e48iid8h5r390ng0dtv1j4s6k', '66.249.64.53', 1567491596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313539363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('295dmoilbk223spreqhjaqrc2oijp9il', '66.249.64.53', 1567491605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313539373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('v7b5ovtscnfs9q3nfpc4euitps940lb2', '66.249.64.53', 1567491605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313539383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('8pp7gc9c81nugd0j0v0bn9r3i2u32gm4', '66.249.64.53', 1567491607, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313539393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('4lljm5di3bn9od8abunnlt01r8lb3bqa', '66.249.64.53', 1567491608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313630303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('9dbcavgpuc6ljfv1ip910rmkef0tkaek', '66.249.64.53', 1567491603, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313630333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('3u5an8mu87dmp5f00pt66cnavetagbs7', '66.249.64.57', 1567491611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313630343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('bh00nvja7drb1dr92i2jvdoslqtb9j9u', '66.249.64.55', 1567491613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313630363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('4g9ioptqmin9a54kuoopg7ei1lqhfaot', '66.249.64.55', 1567491613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313630373b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('jtfr5jutb5ojnf6it6m6j6qd6q6bvebp', '66.249.64.53', 1567491616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('pidmcgo613f5e6ml5r18rf070j49pl4t', '66.249.64.53', 1567491617, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('isf0jel0jtkuhjc24spuid26g7b7eag6', '66.249.64.53', 1567491617, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('56b2im5glut9a0dn8p7vkpuuqtd46pb1', '66.249.64.53', 1567491613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('10hm1ptrf7lts6s9lv90210tb532eq0f', '66.249.64.53', 1567491618, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('0s5evm00a3vq88f964fi4m8pgohb3hms', '66.249.64.53', 1567491620, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('v90jo2q084vpah0ibn2uptit63h945ke', '66.249.64.53', 1567491620, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('tnc44ojot4ottfr1tugqof0timbtjouh', '66.249.64.53', 1567491621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313631393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('umlgn9gk6eo3c8qvdnv39h237s9b4oa2', '66.249.64.53', 1567491623, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('3f14c1qadko1dfpavarsjlg26kr6i1cl', '66.249.64.53', 1567491625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('lgq12b3afakdcv7ijeem032hfg3a9gff', '66.249.64.53', 1567491625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('tpmqe5lfqrovfoqkm4u76p6giikv84j8', '66.249.64.53', 1567491626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('102tfo9mtb005tfi6rumkaog67qspmib', '66.249.64.53', 1567491628, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('hi7h9cpbg5dsbnf9vbpfqcelu7167jcl', '66.249.64.53', 1567491630, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313632393b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('a89bmhn2hd4f6913p01jprjj6febalmp', '66.249.64.53', 1567491632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313633313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('cam393tdtvujpq7iqmj34iqd535jrasc', '66.249.64.53', 1567491634, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313633333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('0m2vm5uqlepcuap3eernomn6g6kuktpb', '66.249.64.53', 1567491636, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313633353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('13crgutsceblqu9sephmokv56heu40h7', '66.249.64.53', 1567491638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313633373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vfab2ts9svigmqt8bc8ujfjb6lbso8rq', '66.249.64.53', 1567491641, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313633393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('oha0312ltooh607kgu70q3dmslple194', '66.249.64.53', 1567491642, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313634313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('icuju24le0ru3sd2e6e5a5ut5drvhmp9', '66.249.64.53', 1567491643, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313634333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('a9kigdu44u4mkr287ej73u2lnpcefnmq', '66.249.64.53', 1567491648, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313634353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('4pnbfglh9esvcgefvjidj2llf4jh29mq', '66.249.64.53', 1567491649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313634363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('69mpcotkftgqnve2hep3ek6nd84q3fj5', '66.249.64.53', 1567491651, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313634383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('eo9c8qbjnjl7n75cqlmnn1gj614taour', '66.249.64.53', 1567491652, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635303b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('sta76bk44qemco3lh08v5hjme4tvi0om', '66.249.64.53', 1567491654, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635313b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('m8p09d3b24dqr548787gpef9dervpah3', '66.249.64.53', 1567491655, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('4htbn3htnm21n903c1u3ne7lq1p6le87', '66.249.64.53', 1567491656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('fftnmpa3khg8dbsrboeg876een1c4bpa', '66.249.64.53', 1567491658, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('39bf9nkqlcqln0f1hbd1slflls0ueplt', '66.249.64.53', 1567491659, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313635393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('r5ps0jkenvdg84e865ogfs74nm0fvog9', '66.249.64.53', 1567491663, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313636333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('kc3j86pn9ttjn434tp2dhho9i7k3r10e', '66.249.64.57', 1567491666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313636343b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('o8vu7chqa7d89b9vhe2kikqp2kk98r9f', '66.249.64.53', 1567491668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313636373b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('33n8mnbs6ig6jn04itsffpjru0ev20bv', '66.249.64.55', 1567491669, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313636383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('fuasqplepnvd1c15uvs2vtlag4kd3bpr', '66.249.64.55', 1567491671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313637303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('6h3lilko9en5jf91cfml4u8b63d7fpnd', '66.249.64.53', 1567491761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313736313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('uuu97fsqrbjgtb4giv7uiiogc5ic405c', '66.249.64.53', 1567491835, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313833353b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('sg0mgs8uhiee47409gl8ivlb7enpipbd', '66.249.64.53', 1567491838, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313833383b),
('9js0sj76bdeg1f49o1jhokj5817qhhsd', '66.249.64.53', 1567491859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313835393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('5h63kr7ntdlg0bl35iebb9pp2h6o9amq', '66.249.64.55', 1567491862, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313836323b),
('hmto396c91v0t08rbd69on0ctv4q60o2', '66.249.64.53', 1567491884, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313838333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('juidnb9et832hm1nhsn8jvsivln0tq83', '66.249.64.53', 1567491908, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313930383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('3fdbpg6g0auv1hpk9uljfl2rhr0l5bd4', '66.249.64.53', 1567491921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313932303b),
('k5hsoif34h8trvlgc5bprlqokishicbl', '66.249.64.53', 1567491933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313933323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('hfb0hhkefhcots2gc4pii0hmejkuei8b', '66.249.64.53', 1567491957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313935363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('mkdl1pvet66ev9rjjbooe810tg6rggtt', '66.249.64.57', 1567491981, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439313938313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('tagp7stqip8pki3a1ddpiqbkjka4dckv', '66.249.64.57', 1567492226, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323232363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('3rbb5lp1g2h7umjcb2iv8jnttsiv1tfi', '66.249.64.57', 1567492492, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323439323b),
('i06s7ia6e1ue5n4eg6jdhg1jv2amju42', '66.249.64.53', 1567492941, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323934313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('0bbmtqoritg8gksqkg1ikobhe44nnsdk', '66.249.64.53', 1567492960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323936303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('l5ff4dh0j9jpt8ei7i0fi7lunijolt7s', '66.249.64.53', 1567492979, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323937383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('l82kvb4cq9mn877e7mnqek6hijhd67bu', '66.249.64.53', 1567492998, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439323939383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('11d024mlsirj8o0eq11qe9nt1uinn01t', '66.249.64.55', 1567493018, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439333031383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('9pjc95rs4rrggb4gq10luk3bbn088cfc', '66.249.64.53', 1567493040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439333033393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('vma7325do5fl6g9tt5u0o06s3peaalir', '66.249.64.53', 1567493077, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439333037363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('lnrmjm3mk4p7qsr2eudv5pbdahid4ikr', '46.229.168.129', 1567497267, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439373236373b),
('qpjlghi3jevsmhcqbe4btkg8gkhgsda4', '66.249.64.57', 1567498429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439383432393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('a194hfvi715sksrv82nagrbr2e382our', '66.249.64.53', 1567498613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439383631333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('8osaurm12m0sq0b96n0o0jb99l22t6t6', '66.249.64.55', 1567498615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439383631353b),
('sd7ff9und2oeeih858r5tgnno0hfifsd', '66.249.64.53', 1567498664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373439383636343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('h2300jiuj1898u12chdtru40qupuktav', '66.249.64.53', 1567501249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373530313234393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('kphrmc2ca8hkj4370rg8blo58d9qa5pl', '66.249.64.57', 1567516668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373531363636383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('olofdln1n5soj13nutpclgads5472dh4', '66.249.64.57', 1567525710, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532353731303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('9m054eg3mp9bmj248728fl10fempvgc4', '66.249.64.53', 1567527900, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532373839383b),
('6j2ga7jad7qrsor55pgde8irgcfsrnis', '66.249.64.53', 1567528192, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532383139323b),
('ld3v4c7fth4mk9vvetshkmm8fk83qf07', '66.249.69.246', 1567530695, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533303639353b736974655f6c616e677c733a323a224172223b646972656374696f6e7c733a333a2272746c223b),
('4tkofu0mr2ic4ejskfj6h15vk8eehp1m', '66.249.69.246', 1567530915, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533303931343b736974655f6c616e677c733a323a224172223b646972656374696f6e7c733a333a2272746c223b),
('nf67ci91hkatkgecv5fbaj7n8d5l6bqg', '66.249.69.248', 1567531354, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533313335343b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('r29d5jj78il0cm1m5foijvg359i6ap44', '66.249.69.246', 1567531696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533313639363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('sg1gsa0lgd3c71sgpt5p2n4r8anrir0f', '66.249.69.244', 1567532117, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533323131373b),
('js6pf6sk33sd4dkg4eq6kduriou1vt3f', '66.249.69.244', 1567532441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533323434313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('s3vm6esdd8ash0182jd8cpg1520h4u33', '66.249.69.244', 1567532889, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533323838393b),
('hlnhtk6ksr3u152f8hd4lt7jhlvo605s', '66.249.69.244', 1567535911, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533353931313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('59ld589j44endne9640j5v6l424dhi8m', '66.249.69.244', 1567536137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533363133373b),
('g3m6vm41jvl36qp88dmg6a4in8e5tfg9', '66.249.69.248', 1567537664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533373636343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('au7i7051n8j7v327ujrn0235phoe4v9a', '66.249.69.248', 1567538244, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533383234343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('dglni6ndro0jp0nks66vndias092doi1', '66.249.69.246', 1567538249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533383234393b),
('k912pl950djcuqq0f9js3d4qc0jffjbr', '66.249.69.246', 1567539866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533393836363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('5rt782j9cuavb2t6cclep79pih7k9fpi', '194.246.88.14', 1567541324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313332343b),
('96dgl6h26gcr995i7j8nvi51f2019jtg', '66.249.69.244', 1567541062, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313036323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('fnuu1lriorc2fol44e7c0pgdl37pijq0', '194.246.88.14', 1567544089, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534343038393b),
('mbbohthpbrv1uelgjhmmse3ft3s87qno', '45.123.118.71', 1567542596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323539363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ijhvhdjn12hgkkdiktnt1g9r6mp5q9o0', '66.249.69.246', 1567541979, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313937393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('v8lt2e2nguiaugfvsefepor1d590uv5c', '66.249.69.248', 1567541982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313938313b),
('o1a7a7ttu9k97j01i0qsb23pjq4n3n2a', '45.123.118.71', 1567542698, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323539363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b636170576f72647c4e3b),
('7scdvfmduu10dk33ralu9pg55d93qqbs', '45.58.142.29', 1567542687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323638373b),
('unjdu1keknvq7jt27961snrnq5oeh3r6', '45.58.142.29', 1567542696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323639363b),
('q2mf90na20iqrbnl1sb9bgah54ohq208', '66.249.69.248', 1567542942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323934323b),
('41o542v35a2adveov6pk23cs7i2f939a', '194.246.88.14', 1567544691, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534343639313b),
('f21q1qnf1rop81vfaabqa48kksbq9tqb', '194.246.88.10', 1567547537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534373533373b),
('920dlji374k33s3ia24oruthtikicsk8', '194.246.88.10', 1567547601, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534373533343b),
('vpom5bhfv2ohdn41th23nasbnfj1u6o8', '194.246.88.10', 1567548723, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534383732333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('sng6g5nfveqpvc4jj0l186u297f89b8l', '194.246.88.10', 1567548724, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534383732333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('ptg4o424qb01f9lgi5p46mtc6bi29fn0', '45.123.118.71', 1567556497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535363439373b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('cffgreiktuiegd8biudfqqhaajovas0k', '45.123.118.71', 1567557975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535373937353b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('4p9ii341erra6uqpdgojspcn3nlv7q30', '45.58.142.29', 1567557082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535373038323b),
('5vcuq95japm5sden9uomnkohkf8f6ece', '66.249.75.185', 1567557082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535373038323b637074636f64657c733a343a2247374b35223b),
('m2apdekfs1vn4f6823cer0ji8usunp2a', '45.123.118.71', 1567558916, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535383931363b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('uqsgoar1uai1pgiivmqga6ksa49in31f', '45.123.118.71', 1567559240, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535393234303b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a303a22223b757365725f656d61696c7c733a33393a22726176696e646572707572692e77617665696e666f746563682e62697a40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227177657277716572223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b),
('a8hfh7kqk2facpvh65sgjhmmk04bdvoe', '45.58.142.29', 1567559124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535393132343b),
('rt4um8fi3ejupvk5592e0angnj3ga22k', '45.58.142.29', 1567559205, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535393230353b),
('l7im9bhqs56bsfd11lu9m8hr66fba6qe', '45.123.118.71', 1567559925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373535393932353b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a303a22223b757365725f656d61696c7c733a32333a22676f6f676c652e6c696b65406f75746c6f6f6b2e636f6d223b66697273745f6e616d657c733a383a22546f7964656d6972223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('rfgcbau4uo93q8u7lk2k6dacvnr167ec', '45.123.118.71', 1567560615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536303631353b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22343637223b757365725f656d61696c7c733a32303a22434c49434b324d41494c40676d61696c2e636f6d223b66697273745f6e616d657c733a373a2254657374736570223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('mo4e1bsft4pn8jm4saqtr7gtnm9ve2lv', '45.123.118.71', 1567561226, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536313232363b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22343637223b757365725f656d61696c7c733a32303a22434c49434b324d41494c40676d61696c2e636f6d223b66697273745f6e616d657c733a373a2254657374736570223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('fp0dja0pp0r5qpguk8r027bioeck0af9', '45.123.118.71', 1567562005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536323030353b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a303a22223b757365725f656d61696c7c733a32303a22434c49434b324d41494c40676d61696c2e636f6d223b66697273745f6e616d657c733a373a2254657374736570223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('enq7to86g5ng31l5opnkjv0ptlp02813', '45.123.118.71', 1567563288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536333238383b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22323233223b757365725f656d61696c7c733a33393a22726176696e646572707572692e77617665696e666f746563682e62697a40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227177657277716572223b736c75677c733a383a227165777271776572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('36a5ce8k7lteaffneoeb74toenk2r3cj', '45.123.118.71', 1567565522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536353532323b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22323233223b757365725f656d61696c7c733a33393a22726176696e646572707572692e77617665696e666f746563682e62697a40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227177657277716572223b736c75677c733a383a227165777271776572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('vpd4comltc3pjcu8b6ifh8i5m74baoaq', '45.123.118.71', 1567565208, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536353230363b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22323233223b757365725f656d61696c7c733a33393a22726176696e646572707572692e77617665696e666f746563682e62697a40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227177657277716572223b736c75677c733a383a227165777271776572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2247374b35223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('em8oo173au8iakjcn45p4unq6iooj2qm', '45.123.118.71', 1567565582, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373536353532323b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b757365725f69647c733a333a22323233223b757365725f656d61696c7c733a33393a22726176696e646572707572692e77617665696e666f746563682e62697a40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227177657277716572223b736c75677c733a383a227165777271776572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a224e325735223b636170576f72647c4e3b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('muh5r1klreiltcr3iqjsdqif4vko8jsb', '194.246.88.10', 1567579060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373537393036303b),
('m7c1is94kcq11fmku5ldnhrq1sj9t4rr', '194.246.88.10', 1567579061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373537393036303b),
('0lj48770r1q57ibiiv41h0bhfrg5ms45', '45.123.118.71', 1567579190, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373537393132333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b636170576f72647c4e3b),
('gleij1qetvhl7pkg7vkm0hn98hpnc1l2', '194.246.88.10', 1567579518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373537393531383b),
('cp723a80eg1m492v8bviiuooabote3fq', '84.217.207.129', 1567584939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373538343833333b),
('2cn6uprc7dfpsm11nuf2ngdsm63k9hl8', '66.249.75.183', 1567587473, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373538373437323b),
('056cmg31vk8n1o2m654lhq5m8ohvttm3', '66.249.75.183', 1567590185, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539303138343b),
('oksf48osk8mt18fojm0fdga0ngf2e8gm', '66.249.75.183', 1567591858, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539313835383b),
('a21fuih6gu34ub50c3vqtbtll4k22lea', '66.249.75.181', 1567594489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343438393b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('smnikurkjs2347ohv5lg8h17ucsg1fnp', '66.249.75.183', 1567594491, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343439313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('hnmdeoakk2ok8pb4qrqqn8569iqa061m', '66.249.75.181', 1567594496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343439353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('l21ggf5cevpsns5ciab18mfqstf63ql2', '66.249.75.183', 1567594498, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343439383b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('eds4mtgs7llqrkhh5d66d8sht2j3h6hd', '66.249.75.185', 1567594506, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343530363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ra37eqoasoddaouft1sjfk187mjteg9a', '66.249.75.181', 1567594512, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343531313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('5m7vpn61du4n7dnai5ea1envj087crdr', '66.249.75.181', 1567594531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343533303b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('uuagjs4hjivo5hctai5ve0j51ld8f1m0', '66.249.75.181', 1567594542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343534323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('l4vc23v7ri5ojh294hqg3o724ffpgh5f', '66.249.75.181', 1567594545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343534343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('t3fr29u8909nl0a8b99ba0c7jpii6rnb', '66.249.75.181', 1567594553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343535333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('edop1vdk486ms8mm8rd323nqaako439u', '66.249.75.181', 1567594557, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343535363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('nqadkqjgr0op6k95kf85gmkcf0sbd6pi', '66.249.75.181', 1567594559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343535393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('jnbkr26lnlk1nh0tc7t8risc5fe4gb4t', '66.249.75.181', 1567594562, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343536313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('n8d22vo4lb7qadpqkudu7a6gm75t8eni', '66.249.75.183', 1567594571, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343537303b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0dds7p4knob11absbrueav015v1qlgui', '66.249.75.181', 1567594579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343537393b),
('efr73k6vpcng1rfgod53j4ieicg0vuf7', '66.249.75.181', 1567594582, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343538313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('ocn88edd5ppq7cdvro092urrr0n2712j', '66.249.75.181', 1567594593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343539323b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('66cfku0v48aq6rh2njt20mp4t785c33b', '66.249.75.181', 1567594597, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343539363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('ogmcg6ois3r1qg0pn93ccu2tf0k55051', '66.249.75.181', 1567594602, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343630323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('h4u0i4k50ppi99nmrham8nfik5psl6sl', '66.249.75.181', 1567594612, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343631313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('3o44n1e5fvnmuol2gl5jshim69ftuvc3', '66.249.75.181', 1567594616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343631353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('vl063184ntlhht19b2eii5t2oi5fjp8d', '66.249.75.183', 1567594622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343632323b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('nca1mal46pc49oal91t94ot2jfi9bcse', '66.249.75.181', 1567594629, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343632383b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('1hahqkbivq19i4kfalocie5mrfldmf9s', '66.249.75.181', 1567594640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343633393b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('0q855082suu5k3682gc322rk9668127c', '66.249.75.181', 1567594645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343634343b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('e0r2r5mq39m6ipm0barj1drvomqj8nb5', '66.249.75.181', 1567594654, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343635343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('vbm7e112q68luta38li9f7s4m8rp6d7m', '66.249.75.181', 1567594659, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343635383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('f90hvmav0m9371280659t06pqrc6pap7', '66.249.75.181', 1567594671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343637313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('i7p09h36k0899b5nvfsqk753e63vtfve', '66.249.75.181', 1567594674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343637343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('u03mpflo7jd2lvpgmv4ki4lvvnfpll41', '66.249.75.181', 1567594676, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343637353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('5qlrhcrm6m49gclkf3k81p5pum0qt7hj', '66.249.75.181', 1567594678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343637373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('5fm3g63tuln8qik5l55u7lb2ht0gb35j', '66.249.75.183', 1567594684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343638333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('8r36s187fi9r3fc8n2lhk3oinp80g9v1', '66.249.75.181', 1567594694, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343639333b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('6f482tlosuqsrjklf616cflj65vhug8d', '66.249.75.181', 1567594699, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343639383b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('mbpgqje4sn9vd5m193v723hld5pa4o78', '66.249.75.181', 1567594709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343730383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('arm5phbbbtpcsg5ilvi164lv1a6vmm71', '66.249.75.181', 1567594714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343731323b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('kcsqdrclgafm1kh8mfrugt2btb5d9ema', '66.249.75.181', 1567594922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343731373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('b3jdoq5kmn3hudgn5dtq0k0s4koqjspt', '66.249.75.181', 1567594722, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343732313b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('87asbskil6hmlipo1q7a2kpmsvc8mak2', '66.249.75.181', 1567594729, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343732383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('72tq05395jpqgvamioo9opu3cf9ogk5l', '66.249.75.181', 1567594734, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343733333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('3aie32bo4jt4a7ji84gqgr40juifoe9g', '66.249.75.181', 1567594742, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343734323b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('67qdpm27553mcqnpgj662iujoajbak50', '66.249.75.181', 1567594747, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343734373b),
('ildu0sbigao9fve5aplk8cre8l0jr5vn', '66.249.75.181', 1567594761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343736313b),
('6a67ci5qmlqhjjk7oi2dq4udmioork66', '66.249.75.181', 1567594766, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343736353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539343635663364223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('lrj7jjlnahj6fml8nfq96rv13irhmotb', '66.249.75.181', 1567594769, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343736393b),
('0b4tofh200e4h8jar2lnrp26s9a1g5h4', '66.249.75.181', 1567594775, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343737353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('sp62ac3p0kvocan20j3t5crh8nrpndh7', '66.249.75.181', 1567594784, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343738333b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('jtgqq0pfbnlv00o5iq2gdsjdnc9lv5m5', '66.249.75.181', 1567594790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343738393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353934363566336437383435223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('516s3k1iv4c749fb0ln6p2un159h9u7o', '66.249.75.181', 1567594793, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343739323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353934363566336436323539223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('1fsactu3jgv7v85i4kac8pcbi7q05uce', '66.249.75.181', 1567594799, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343739383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32363a2263616e6469646174652f36323539343635663364336337373431223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('7lsnu8a1tqh8rsshbh7eecgf83b2tpfh', '66.249.75.181', 1567594807, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343830363b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('qbi7kb785va2j4c1j9n5q3tq2i1vdldv', '66.249.75.181', 1567594812, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343831323b),
('b1sbo9v70ai548n9r5thh4r1jch6orkm', '66.249.75.181', 1567594886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343838353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('v2mv7f786hh28mmlak5kco70kkkbe4ag', '66.249.75.181', 1567594947, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343934363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539376336363539223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('a7c10unr6lcaic0t44p9flmngglsbcs6', '66.249.75.181', 1567594952, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539343935323b),
('scg3koe8of90n5c9skhto4mcq1s2162r', '66.249.75.181', 1567595087, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353038343b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('0605d9n0j6kmacamev4ujppduupg5jjv', '66.249.75.181', 1567595088, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353038353b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('380j725p17p20afb9cba9jierfaei48m', '66.249.75.183', 1567595132, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353133303b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('69naov8q8ams7vef9fb1pa6utqml8nj9', '66.249.75.181', 1567595489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353438383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32363a2263616e6469646174652f36323539376336363539376336363539223b6d73677c733a36353a2256c3a46e6c6967656e206c6f67676120696e20736f6d206172626574736769766172652066c3b67220617474207365206b616e646964617470726f66696c656e2e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('u3rquifvluufmsp0io0lkhdda3beu8jj', '66.249.75.183', 1567595493, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353439333b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('knon6335q03765q8216f8gon05t2irib', '66.249.75.181', 1567595495, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353439343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('fn6lhbm5q0cf5shmu5bkf6f3k6dmbjbn', '66.249.75.183', 1567595496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353439353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('lca2ltg0l8t881o6sggr9r5crra6mui4', '66.249.75.181', 1567595498, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353439383b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('g6g6hi7e905ctqkdhmj8jc4utqgetrvp', '66.249.75.181', 1567595501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353530303b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('fvj9estdjgmeqplmajn14mbogbtmt6s8', '66.249.75.181', 1567595502, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353530313b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('vsko503veo897ldh1hlsuj37jg2m1f9k', '66.249.75.181', 1567595503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353530323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('r9mqdru7s1dog2ac6dtohot6j9m7sc3e', '66.249.75.181', 1567595518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353531373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('1ooqfr9972t3j7kme9qirf820em5s32m', '66.249.75.181', 1567595520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353531393b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('uig0vbd6qejb23nhldkls92rp3dss772', '66.249.75.181', 1567595523, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353532323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('g5uql4mjqgda85ogvpinm65nuaquipub', '66.249.75.181', 1567595524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353532343b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('bqf44all8c14kkf3bo4spbdss5j00292', '66.249.75.181', 1567595525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353532353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('jd8lt6gdubho0gepri0s2gj840dq550o', '66.249.75.181', 1567595526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353532363b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('kjpbss20rhae649t5fgsp02p0tkasi78', '66.249.75.181', 1567595528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353532383b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('gl056k2etgb2tag5n3shu7fqgukbfc4p', '66.249.75.181', 1567595542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353534313b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('q3mdvvob8a59j26t8r7t68t3k5gk71ig', '66.249.75.181', 1567595545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353534343b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('m0kv4ipd0vcmqnsdhqfbgdf50q0codrb', '66.249.75.181', 1567595546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353534353b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('q6mrbahr3q2hc91pbr7jtg7qrpec1ltp', '66.249.75.181', 1567595547, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353534363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('34sqv46p429nt6k537b977plj4s3i5bj', '66.249.75.181', 1567595554, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353535333b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('nrdc26431461fuc0gm94uh00qefrj7qm', '66.249.75.181', 1567595557, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353535373b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('3vas6299b69d7q8ktfi12r2u79rmhf4g', '66.249.75.181', 1567595567, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353536373b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('oufgddtutkvnqrltin83hjs9upi5p0vd', '66.249.75.181', 1567595571, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353537303b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('jnnsuvmi26vnhshhrn1uot96skqbb1ig', '66.249.75.181', 1567595574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353537333b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('d9mkv4cnf9ss71rau6cvb2klulq60484', '66.249.75.181', 1567595577, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353537373b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('vd9862v9gd4t89o76of11enk1b20mkdc', '66.249.75.181', 1567595587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353538373b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bobfmj45qbr7ad77kliih55t0q6oqbaq', '66.249.75.183', 1567595597, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353539363b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('rkfo79ge92a95n28li1ephdog9sjnkac', '66.249.75.181', 1567595600, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353539393b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('23raav7r0p3tqd2klvfkuopsc75h7jvp', '66.249.75.181', 1567595607, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353630363b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('bc41gmakttaikcb7su8kv9m5mifkocic', '66.249.75.181', 1567595613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353631323b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('4v5atv6bsqca479t3oqnen6nlmtc2ogt', '66.249.75.181', 1567595616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353631353b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('li81sle17l7ofj7l95oit44osgdkuim4', '66.249.75.181', 1567595619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353631383b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('sr83tcm6b87dptaprmm52tfaossord7t', '66.249.75.181', 1567595622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353632323b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('b361ta1hgp438uic7gip5gq5ln7qdqgp', '66.249.75.181', 1567595632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353633313b736974655f6c616e677c733a323a22534f223b646972656374696f6e7c733a333a226c7472223b),
('6hap24g9ftpkrrvaqd4pofu0k0q2qees', '66.249.75.185', 1567595654, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353635333b736974655f6c616e677c733a323a224652223b646972656374696f6e7c733a333a226c7472223b),
('98ubb9mgfp82dl7bta9dfvp72n5j4q7j', '66.249.75.181', 1567595673, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353637333b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('idto0e1ncoc28krc5cs0konkgn2b82is', '66.249.75.181', 1567595679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353637383b736974655f6c616e677c733a323a225356223b646972656374696f6e7c733a333a226c7472223b),
('1altmir4tasui2efl2dgbh8hj7nqu1i0', '66.249.75.181', 1567595684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353638343b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b),
('t98m4lekd2tcmpf5tl9mrn80j2dtq81f', '66.249.75.181', 1567595687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353638363b736974655f6c616e677c733a323a224553223b646972656374696f6e7c733a333a226c7472223b),
('pa9gm0eoqt6f0v2esbrfebfrv9676lfj', '66.249.75.181', 1567595689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539353638393b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('avc2eg0hqv1lalguabpc33dg77p50ifn', '66.249.75.185', 1567596117, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539363131363b736974655f6c616e677c733a323a224152223b646972656374696f6e7c733a333a2272746c223b636170576f72647c4e3b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('uhdvj99t5fgtk1g79lc1oiir1r9h9n56', '45.58.142.29', 1567596117, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539363131373b),
('2bdsjijmo1tovej42otip4fmitk3k75h', '66.249.75.185', 1567597820, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539373832303b),
('s91mjsa0rhdseafjgmu0jtmgh52s247r', '66.249.75.181', 1567598122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539383132323b),
('a1j3egfdqnjvomq8d881q7vf0mu4v7od', '66.249.75.185', 1567599504, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539393530343b),
('3q0rsk64am0qmoe7t24d6qjk0sifis3i', '194.246.88.10', 1567600084, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630303038343b),
('d4s3i1qiv6oq4al644dbt0cnm1muvq3k', '66.249.75.185', 1567602251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630323235303b),
('mfb6uh21ia5r9dvfle1cbqv9t31q7sch', '52.114.142.71', 1567605326, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630353332353b),
('ognjpotrgectpok78kdg2ttcn6oac85s', '52.114.77.26', 1567605343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630353334333b),
('dngtlh4s490a6siunkuc8s7dp1eu17r7', '27.147.160.253', 1567606931, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630363838353b),
('c99pre97llv4qetlrm0hhmr6srdso9h2', '5.122.49.216', 1567611365, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373631313336323b),
('cmipcid3jp6tprgu1vddc8nknl1vfv5a', '45.123.118.71', 1567612676, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373631323637343b),
('kafhord7ue8n0vfjthqofhqhahql3a6s', '84.217.207.129', 1567621520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632313437303b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('nr01seocccjck99d27tikpt38j4vrad2', '194.246.88.10', 1567628484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383438343b),
('u9phvuop3tbpvjj8e3dr0k6j41mfrv4b', '1.186.198.134', 1567627497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632373437323b),
('37899hhl3sh5rdl4n1b57je0m9fqaseo', '1.186.198.134', 1567628728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383732383b636170576f72647c4e3b),
('ohfgvhaofd561t907n9g0jk8ocjruh54', '45.58.142.29', 1567627599, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632373539393b),
('jpnfsos22igue9pa0tig0vnh01vrev64', '45.58.142.29', 1567627608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632373630383b),
('652o3dff4031jtflm77br869snlebjof', '194.246.88.10', 1567628484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383438343b),
('4r7crcdet96qpjvuek9dpvduvkm6vune', '1.186.198.134', 1567628852, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383732383b636170576f72647c4e3b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('pnnf33pvbot8knlp2ma7r2l370etthdf', '45.58.142.29', 1567628811, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383831313b),
('s8nlmlsc3itjfscpcn12ge86t2c6d9an', '45.58.142.29', 1567628839, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383833393b),
('86oeludlq7bpttn8414c19ui0e5pmfij', '45.58.142.29', 1567628852, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373632383835323b),
('utagrlpm45an4spohkmddp8c82ngusua', '1.186.248.180', 1567674281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637343237393b),
('3tjurdsge386421r1dr03empfbur5im4', '1.186.248.180', 1567674281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637343237393b),
('mv5caceuhk1f5qh2b8gnosmquo2sehsf', '1.186.248.180', 1567674281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637343238313b),
('hb1lldnen7ljak2f821250u8bkoce9sl', '1.186.248.180', 1567675886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637353838363b),
('hh7cvdag7989isj5ji7avdur05fe8go5', '1.186.248.180', 1567675886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637353838363b),
('n05tj5u751u54rnek0ct049gg5dkrg78', '42.106.197.117', 1567684551, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638343534393b),
('7e61vc8dnpite67cdosiin953dmph3fe', '1.186.248.180', 1567686622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363632323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353933633737343137383435223b636170576f72647c4e3b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b),
('94romlr26j0m78qbrh1c8o3ha3um0v71', '45.58.142.29', 1567686313, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363331333b),
('93dlf7c1vca4ps7rrpnpjm3j08qu9le1', '45.58.142.29', 1567686332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363333323b),
('f2qafvjfqo2oipq4kemsfg834iqk7vj1', '45.58.142.29', 1567686345, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363334353b),
('h3s1n5su8bu79ahecvlpm68m23hg1a0b', '45.58.142.29', 1567686349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363334393b),
('gcp99dftk1kobqgduiob2aqbrv8tb8jq', '45.58.142.29', 1567686356, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363335363b),
('23vt4445q9lissruq8mbg29al6a9bpl0', '45.58.142.29', 1567686362, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363336323b),
('pkuoars53kubpj3pjgctu80tsqu60250', '45.58.142.29', 1567686373, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363337333b),
('s9801sukp95koehi3apn51kkp4evtk8l', '1.186.248.180', 1567686636, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638363632323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353933633737343137383435223b636170576f72647c4e3b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('ugacecrt7gkahbkuo9bdv34mvf7r4685', '61.75.61.226', 1567687811, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638373737353b),
('0pqvjrnadh05gtlg5ecrfag2ppd6bkt7', '61.75.61.226', 1567687996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638373939363b),
('2q1sdv37gl3nqi8f1ga7l1btovu0dmho', '61.75.61.226', 1567687998, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638373939383b),
('6qtnsu4h71jo6faj89bq8vj9vh1n2hob', '45.123.118.71', 1567688245, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638383135373b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('meaa488c178644varaauhvig6h4porm4', '192.99.100.98', 1567688709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638383730393b),
('cavvm6ts4m2hdql6b64hoe3ksf3prsjp', '46.229.168.152', 1567702023, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730323032333b),
('ii7nis93nvmog4t5qfsegkfemhr89kor', '66.249.64.55', 1567705457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730353435373b636170576f72647c4e3b),
('qkn450r92knc442pjgtudkvle4qk59p5', '66.249.64.53', 1567713726, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373731333732353b736974655f6c616e677c733a323a224641223b646972656374696f6e7c733a333a2272746c223b),
('e5etaf1csqj0mrn45011vla4ci0s2tc9', '66.249.64.57', 1567733248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373733333234333b),
('h8k3l84d7erh41of3nsknkktrgpdiaoc', '66.249.64.55', 1567747479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373734373437373b),
('1ithte3csj5qs51sn6i7og2jfhl85tah', '66.249.64.57', 1567759650, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373735393634373b736974655f6c616e677c733a323a22656e223b646972656374696f6e7c4e3b);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `ID` int(11) NOT NULL,
  `emails_per_hour` int(5) DEFAULT NULL,
  `upload_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`ID`, `emails_per_hour`, `upload_limit`) VALUES
(1, 300, 500000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_skills`
--

CREATE TABLE `tbl_skills` (
  `ID` int(11) NOT NULL,
  `skill_name` varchar(40) DEFAULT NULL,
  `industry_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_skills`
--

INSERT INTO `tbl_skills` (`ID`, `skill_name`, `industry_ID`) VALUES
(1, 'html', NULL),
(2, 'php', NULL),
(3, 'js', NULL),
(4, '.net', NULL),
(6, 'jquery', NULL),
(7, 'java', NULL),
(8, 'photoshop', NULL),
(9, 'illustrator', NULL),
(10, 'Indesign', NULL),
(11, 'mysql', NULL),
(12, 'Ms Office', NULL),
(13, 'Marketting', NULL),
(14, 'informÃ¡tica', NULL),
(15, 'web', NULL),
(16, 'indesing', NULL),
(17, 'developer', NULL),
(19, 'ghjhtrnjh', NULL),
(20, 'htrkfvvf', NULL),
(22, 'corp mkt', NULL),
(23, 'direct mkt', NULL),
(24, 'sales skills', NULL),
(25, 'magento', NULL),
(26, 'indesign', NULL),
(28, 'teaching', NULL),
(29, 'test', NULL),
(30, 'tester', NULL),
(31, 'css', NULL),
(32, 'word', NULL),
(33, 'hhhhh', NULL),
(34, 'lärare', NULL),
(35, 'laravel', NULL),
(36, '2', NULL),
(37, 'asa', NULL),
(38, 'sa', NULL),
(39, 'as', NULL),
(40, 'coaching', NULL),
(41, 'undervisning', NULL),
(42, 'sälj', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stories`
--

CREATE TABLE `tbl_stories` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) NOT NULL,
  `is_featured` enum('yes','no') DEFAULT 'no',
  `sts` enum('active','inactive') DEFAULT 'inactive',
  `title` varchar(250) DEFAULT NULL,
  `story` text,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_job_seeker` (`id_job_seeker`),
  ADD KEY `id_employer` (`id_employer`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ad_codes`
--
ALTER TABLE `tbl_ad_codes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_channels`
--
ALTER TABLE `tbl_channels`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_cms`
--
ALTER TABLE `tbl_cms`
  ADD PRIMARY KEY (`pageID`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  ADD PRIMARY KEY (`id_conversation`),
  ADD KEY `id_employer` (`id_employer`),
  ADD KEY `id_job_seeker` (`id_job_seeker`);

--
-- Indexes for table `tbl_conv_message`
--
ALTER TABLE `tbl_conv_message`
  ADD PRIMARY KEY (`id_conv_message`),
  ADD KEY `id_sender` (`id_sender`),
  ADD KEY `id_conversation` (`id_conversation`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_email_content`
--
ALTER TABLE `tbl_email_content`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_employers`
--
ALTER TABLE `tbl_employers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_employer_certificate`
--
ALTER TABLE `tbl_employer_certificate`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `tbl_employer_files`
--
ALTER TABLE `tbl_employer_files`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `job_ID` (`job_ID`),
  ADD KEY `employer_ID` (`employer_ID`);

--
-- Indexes for table `tbl_favourite_candidates`
--
ALTER TABLE `tbl_favourite_candidates`
  ADD PRIMARY KEY (`employer_id`);

--
-- Indexes for table `tbl_favourite_companies`
--
ALTER TABLE `tbl_favourite_companies`
  ADD PRIMARY KEY (`seekerid`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_institute`
--
ALTER TABLE `tbl_institute`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_interview`
--
ALTER TABLE `tbl_interview`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `tbl_job_alert`
--
ALTER TABLE `tbl_job_alert`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_job_alert_queue`
--
ALTER TABLE `tbl_job_alert_queue`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_job_analysis`
--
ALTER TABLE `tbl_job_analysis`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `tbl_job_functional_areas`
--
ALTER TABLE `tbl_job_functional_areas`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_job_industries`
--
ALTER TABLE `tbl_job_industries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_job_seekers`
--
ALTER TABLE `tbl_job_seekers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_job_titles`
--
ALTER TABLE `tbl_job_titles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_labels`
--
ALTER TABLE `tbl_labels`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `tbl_labels_dtl`
--
ALTER TABLE `tbl_labels_dtl`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `label_id` (`label_id`),
  ADD KEY `fk_id` (`fk_id`);

--
-- Indexes for table `tbl_lang`
--
ALTER TABLE `tbl_lang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Abbreviation` (`Abbreviation`);

--
-- Indexes for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_post_jobs`
--
ALTER TABLE `tbl_post_jobs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `job_analysis_id` (`job_analysis_id`),
  ADD KEY `interview_id` (`interview_id`),
  ADD KEY `employer_certificate_id` (`employer_certificate_id`);
ALTER TABLE `tbl_post_jobs` ADD FULLTEXT KEY `job_search` (`job_title`,`job_description`);

--
-- Indexes for table `tbl_prohibited_keywords`
--
ALTER TABLE `tbl_prohibited_keywords`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_qualifications`
--
ALTER TABLE `tbl_qualifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_quizzes`
--
ALTER TABLE `tbl_quizzes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `tbl_requests_info`
--
ALTER TABLE `tbl_requests_info`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `jobseeker_id` (`jobseeker_id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_scam`
--
ALTER TABLE `tbl_scam`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_seeker_academic`
--
ALTER TABLE `tbl_seeker_academic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_seeker_additional_info`
--
ALTER TABLE `tbl_seeker_additional_info`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `tbl_seeker_additional_info` ADD FULLTEXT KEY `resume_search` (`summary`,`keywords`);

--
-- Indexes for table `tbl_seeker_applied_for_job`
--
ALTER TABLE `tbl_seeker_applied_for_job`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_seeker_experience`
--
ALTER TABLE `tbl_seeker_experience`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_seeker_reference`
--
ALTER TABLE `tbl_seeker_reference`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `seeker_ID` (`seeker_ID`);

--
-- Indexes for table `tbl_seeker_resumes`
--
ALTER TABLE `tbl_seeker_resumes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_seeker_skills`
--
ALTER TABLE `tbl_seeker_skills`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `tbl_seeker_skills` ADD FULLTEXT KEY `js_skill_search` (`skill_name`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_stories`
--
ALTER TABLE `tbl_stories`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_ad_codes`
--
ALTER TABLE `tbl_ad_codes`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_channels`
--
ALTER TABLE `tbl_channels`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_cms`
--
ALTER TABLE `tbl_cms`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  MODIFY `id_conversation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_conv_message`
--
ALTER TABLE `tbl_conv_message`
  MODIFY `id_conv_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_email_content`
--
ALTER TABLE `tbl_email_content`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_employers`
--
ALTER TABLE `tbl_employers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `tbl_employer_certificate`
--
ALTER TABLE `tbl_employer_certificate`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_employer_files`
--
ALTER TABLE `tbl_employer_files`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_favourite_candidates`
--
ALTER TABLE `tbl_favourite_candidates`
  MODIFY `employer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_favourite_companies`
--
ALTER TABLE `tbl_favourite_companies`
  MODIFY `seekerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_institute`
--
ALTER TABLE `tbl_institute`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_interview`
--
ALTER TABLE `tbl_interview`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_job_alert`
--
ALTER TABLE `tbl_job_alert`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_job_alert_queue`
--
ALTER TABLE `tbl_job_alert_queue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_job_analysis`
--
ALTER TABLE `tbl_job_analysis`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_job_functional_areas`
--
ALTER TABLE `tbl_job_functional_areas`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_job_industries`
--
ALTER TABLE `tbl_job_industries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_job_seekers`
--
ALTER TABLE `tbl_job_seekers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=469;

--
-- AUTO_INCREMENT for table `tbl_job_titles`
--
ALTER TABLE `tbl_job_titles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_labels`
--
ALTER TABLE `tbl_labels`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_labels_dtl`
--
ALTER TABLE `tbl_labels_dtl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_lang`
--
ALTER TABLE `tbl_lang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_post_jobs`
--
ALTER TABLE `tbl_post_jobs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `tbl_prohibited_keywords`
--
ALTER TABLE `tbl_prohibited_keywords`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_qualifications`
--
ALTER TABLE `tbl_qualifications`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_quizzes`
--
ALTER TABLE `tbl_quizzes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_requests_info`
--
ALTER TABLE `tbl_requests_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_scam`
--
ALTER TABLE `tbl_scam`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_seeker_academic`
--
ALTER TABLE `tbl_seeker_academic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_seeker_additional_info`
--
ALTER TABLE `tbl_seeker_additional_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `tbl_seeker_applied_for_job`
--
ALTER TABLE `tbl_seeker_applied_for_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT for table `tbl_seeker_experience`
--
ALTER TABLE `tbl_seeker_experience`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_seeker_reference`
--
ALTER TABLE `tbl_seeker_reference`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_seeker_resumes`
--
ALTER TABLE `tbl_seeker_resumes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT for table `tbl_seeker_skills`
--
ALTER TABLE `tbl_seeker_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1106;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_stories`
--
ALTER TABLE `tbl_stories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
