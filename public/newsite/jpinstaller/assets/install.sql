-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 28 Janvier 2018 à 15:09
-- Version du serveur :  5.7.21-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `job`
--

--
-- Procédures
--
DROP PROCEDURE IF EXISTS `count_active_opened_jobs`;
CREATE PROCEDURE `count_active_opened_jobs` ()  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.sts='active' AND CURRENT_DATE < pj.last_date;
END;

DROP PROCEDURE IF EXISTS `count_active_opened_jobs_by_company_id`;
CREATE PROCEDURE `count_active_opened_jobs_by_company_id` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.company_ID=comp_id AND pj.sts='active';
END;

DROP PROCEDURE IF EXISTS `count_active_records_by_city_front_end`;
CREATE PROCEDURE `count_active_records_by_city_front_end` (IN `city` VARCHAR(40))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.city=city AND pj.sts='active' AND pc.sts = 'active';
END;

DROP PROCEDURE IF EXISTS `count_active_records_by_industry_front_end`;
CREATE PROCEDURE `count_active_records_by_industry_front_end` (IN `industry_id` INT(11))  BEGIN
	SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.industry_ID=industry_id AND pj.sts='active' AND pc.sts = 'active';
END;

DROP PROCEDURE IF EXISTS `count_all_posted_jobs_by_company_id_frontend`;
CREATE PROCEDURE `count_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active';
END;

DROP PROCEDURE IF EXISTS `count_applied_jobs_by_employer_id`;
CREATE PROCEDURE `count_applied_jobs_by_employer_id` (IN `employer_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_post_jobs.employer_ID=employer_id;
END;

DROP PROCEDURE IF EXISTS `count_applied_jobs_by_jobseeker_id`;
CREATE PROCEDURE `count_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id;
END;

DROP PROCEDURE IF EXISTS `count_ft_job_search_filter_3`;
CREATE PROCEDURE `count_ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255))  BEGIN
	SELECT COUNT(pj.ID) as total
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active';
END;

DROP PROCEDURE IF EXISTS `count_ft_search_job`;
CREATE PROCEDURE `count_ft_search_job` (IN `param` VARCHAR(255), `param2` VARCHAR(255))  BEGIN
	SELECT COUNT(pc.ID) as total
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = 'active' AND pc.sts = 'active'
AND (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pj.city like CONCAT("%",param2,"%");
END;

DROP PROCEDURE IF EXISTS `count_ft_search_resume`;
CREATE PROCEDURE `count_ft_search_resume` (IN `param` VARCHAR(255))  BEGIN
	SELECT COUNT(DISTINCT ss.ID) as total
	FROM `tbl_job_seekers` js 
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' 
AND ss.skill_name like CONCAT('%',param,'%');
END;

DROP PROCEDURE IF EXISTS `count_search_posted_jobs`;
CREATE PROCEDURE `count_search_posted_jobs` (IN `where_condition` VARCHAR(255))  BEGIN
	SET @query = "SELECT COUNT(pj.ID) as total
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE
";

SET @where_clause = CONCAT(where_condition);
SET @query = CONCAT(@query, @where_clause);

PREPARE stmt FROM @query;
EXECUTE stmt;

END;

DROP PROCEDURE IF EXISTS `ft_job_search_filter_3`;
CREATE PROCEDURE `ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, MATCH(pj.job_title, pj.job_description) AGAINST( param_title ) AS score
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param_title,"%") OR pj.job_description like CONCAT("%",param_title,"%") OR pj.required_skills like CONCAT("%",param_title,"%")) 
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'

ORDER BY score DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `ft_search_job`;
CREATE PROCEDURE `ft_search_job` (IN `param` VARCHAR(255), `param2` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN

	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, MATCH(pj.job_title, pj.job_description) AGAINST(param) AS score
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
END;

DROP PROCEDURE IF EXISTS `ft_search_jobs_group_by_city`;
CREATE PROCEDURE `ft_search_jobs_group_by_city` (IN `param` VARCHAR(255))  BEGIN
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
END;

DROP PROCEDURE IF EXISTS `ft_search_jobs_group_by_company`;
CREATE PROCEDURE `ft_search_jobs_group_by_company` (IN `param` VARCHAR(255))  BEGIN
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
END;

DROP PROCEDURE IF EXISTS `ft_search_jobs_group_by_salary_range`;
CREATE PROCEDURE `ft_search_jobs_group_by_salary_range` (IN `param` VARCHAR(255))  BEGIN
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
END;

DROP PROCEDURE IF EXISTS `ft_search_jobs_group_by_title`;
CREATE PROCEDURE `ft_search_jobs_group_by_title` (IN `param` VARCHAR(255))  BEGIN
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
END;

DROP PROCEDURE IF EXISTS `ft_search_resume`;
CREATE PROCEDURE `ft_search_resume` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
  SELECT js.ID, js.first_name, js.gender, js.dob, js.city, js.photo
	FROM tbl_job_seekers AS js
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' AND ss.skill_name like CONCAT("%",param,"%")
  GROUP BY ss.seeker_ID
	ORDER BY js.ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_active_deactive_posted_job_by_company_id`;
CREATE PROCEDURE `get_active_deactive_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts IN ('active', 'inactive', 'pending') AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_active_featured_job`;
CREATE PROCEDURE `get_active_featured_job` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes' AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_active_posted_job_by_company_id`;
CREATE PROCEDURE `get_active_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_active_posted_job_by_id`;
CREATE PROCEDURE `get_active_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, emp.first_name, emp.email AS employer_email, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,emp.city as emp_city, emp.country as emp_country	
FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON pc.ID=emp.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND pc.sts = 'active';
END;

DROP PROCEDURE IF EXISTS `get_all_active_employers`;
CREATE PROCEDURE `get_all_active_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_all_active_top_employers`;
CREATE PROCEDURE `get_all_active_top_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active' AND emp.top_employer = 'yes'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_all_opened_jobs`;
CREATE PROCEDURE `get_all_opened_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, ji.industry_name 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.sts = 'active' AND pc.sts='active'
	ORDER BY pj.ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_all_posted_jobs`;
CREATE PROCEDURE `get_all_posted_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, pj.ip_address 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_all_posted_jobs_by_company_id_frontend`;
CREATE PROCEDURE `get_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_all_posted_jobs_by_status`;
CREATE PROCEDURE `get_all_posted_jobs_by_status` (IN `job_status` VARCHAR(10), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = job_status
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_applied_jobs_by_employer_id`;
CREATE PROCEDURE `get_applied_jobs_by_employer_id` (IN `employer_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.dated AS applied_date,tbl_seeker_applied_for_job.seeker_ID,tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_job_seekers.ID AS job_seeker_ID, tbl_post_jobs.job_slug, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.slug
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_post_jobs.employer_ID=employer_id 
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_applied_jobs_by_jobseeker_id`;
CREATE PROCEDURE `get_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.ID as applied_id, tbl_seeker_applied_for_job.dated AS applied_date, tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_companies.company_name, tbl_companies.company_slug, tbl_companies.company_logo 
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_employers ON tbl_employers.ID=tbl_post_jobs.employer_ID
	INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_ID
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_applied_jobs_by_seeker_id`;
CREATE PROCEDURE `get_applied_jobs_by_seeker_id` (IN `applicant_id` INT(11), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT aj.*, tbl_post_jobs.ID AS posted_job_id, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.employer_ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_companies.company_name, tbl_companies.company_logo, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.photo
	FROM `tbl_seeker_applied_for_job` aj
	INNER JOIN tbl_job_seekers ON aj.seeker_ID=tbl_job_seekers.ID
	INNER JOIN tbl_post_jobs ON aj.job_ID=tbl_post_jobs.ID
	INNER JOIN tbl_companies ON tbl_post_jobs.company_ID=tbl_companies.ID
	WHERE aj.seeker_ID=applicant_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_company_by_slug`;
CREATE PROCEDURE `get_company_by_slug` (IN `slug` VARCHAR(70))  BEGIN
	SELECT emp.ID AS empID, pc.ID, emp.country, emp.city, pc.company_name, pc.company_description, pc.company_location, pc.company_website, pc.no_of_employees, pc.established_in, pc.company_logo, pc.company_slug
	FROM `tbl_employers` AS emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE pc.company_slug=slug AND emp.sts='active';
END;

DROP PROCEDURE IF EXISTS `get_experience_by_jobseeker_id`;
CREATE PROCEDURE `get_experience_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_experience.* 
	FROM `tbl_seeker_experience`
	WHERE tbl_seeker_experience.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_experience.start_date DESC;
END;

DROP PROCEDURE IF EXISTS `get_featured_job`;
CREATE PROCEDURE `get_featured_job` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_latest_posted_job_by_employer_ID`;
CREATE PROCEDURE `get_latest_posted_job_by_employer_ID` (IN `emp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_opened_jobs_home_page`;
CREATE PROCEDURE `get_opened_jobs_home_page` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
set @prev := 0, @rownum := '';
SELECT ID, job_title, job_slug, employer_ID, company_ID, job_description, city, dated, last_date, is_featured, sts, company_name, company_logo, company_slug, industry_name 
FROM (
  SELECT ID, job_title, job_slug, employer_ID, company_ID, job_description, city, dated, last_date, is_featured, sts, company_name, company_logo, company_slug, industry_name, 
         IF( @prev <> company_ID, 
             @rownum := 1, 
             @rownum := @rownum+1 
         ) AS rank, 
         @prev := company_ID, 
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
END;

DROP PROCEDURE IF EXISTS `get_posted_job_by_company_id`;
CREATE PROCEDURE `get_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.job_description, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.company_ID=comp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_posted_job_by_employer_id`;
CREATE PROCEDURE `get_posted_job_by_employer_id` (IN `emp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.job_description, tbl_post_jobs.contact_person, tbl_post_jobs.contact_email, tbl_post_jobs.contact_phone, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `get_posted_job_by_id`;
CREATE PROCEDURE `get_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
		SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,em.city as emp_city, em.country as emp_country
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
  INNER JOIN tbl_employers AS em ON pc.ID=em.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id;
END;

DROP PROCEDURE IF EXISTS `get_posted_job_by_id_employer_id`;
CREATE PROCEDURE `get_posted_job_by_id_employer_id` (IN `job_id` INT(11), `emp_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND tbl_post_jobs.employer_ID=emp_id;
END;

DROP PROCEDURE IF EXISTS `get_qualification_by_jobseeker_id`;
CREATE PROCEDURE `get_qualification_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_academic.* 
	FROM `tbl_seeker_academic`
	WHERE tbl_seeker_academic.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_academic.completion_year DESC;
END;

DROP PROCEDURE IF EXISTS `job_search_by_city`;
CREATE PROCEDURE `job_search_by_city` (IN `param_city` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `job_search_by_industry`;
CREATE PROCEDURE `job_search_by_industry` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.industry_ID = param AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END;

DROP PROCEDURE IF EXISTS `search_posted_jobs`;
CREATE PROCEDURE `search_posted_jobs` (IN `where_condition` VARCHAR(255), `from_limit` INT(11), `to_limit` INT(11))  BEGIN
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

END;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `calendar`
--

TRUNCATE TABLE `calendar`;
--
-- Contenu de la table `calendar`
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
(12, 210, 427, 'Interview with Tim S', '2018-01-29 11:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin` (
  `id` int(8) NOT NULL,
  `admin_username` varchar(80) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_admin`
--

TRUNCATE TABLE `tbl_admin`;
--
-- Contenu de la table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_username`, `admin_password`, `type`) VALUES
(1, 'admin', '$2y$10$slp4AjsJfZdyzqVjL.xdk.h3FaR55VKqRFw2g4AdrzVvtR93nr8ve', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_ad_codes`
--

DROP TABLE IF EXISTS `tbl_ad_codes`;
CREATE TABLE `tbl_ad_codes` (
  `ID` int(4) NOT NULL,
  `bottom` text,
  `right_side_1` text,
  `right_side_2` text,
  `google_analytics` text
) ;

--
-- Vider la table avant d'insérer `tbl_ad_codes`
--

TRUNCATE TABLE `tbl_ad_codes`;
--
-- Contenu de la table `tbl_ad_codes`
--

INSERT INTO `tbl_ad_codes` (`ID`, `bottom`, `right_side_1`, `right_side_2`, `google_analytics`) VALUES
(1, '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_cities`
--

DROP TABLE IF EXISTS `tbl_cities`;
CREATE TABLE `tbl_cities` (
  `ID` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `city_slug` varchar(150) NOT NULL,
  `city_name` varchar(150) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '998',
  `country_ID` int(11) NOT NULL,
  `is_popular` enum('yes','no') NOT NULL DEFAULT 'no'
) ;

--
-- Vider la table avant d'insérer `tbl_cities`
--

TRUNCATE TABLE `tbl_cities`;
--
-- Contenu de la table `tbl_cities`
--

INSERT INTO `tbl_cities` (`ID`, `show`, `city_slug`, `city_name`, `sort_order`, `country_ID`, `is_popular`) VALUES
(14, 1, '', 'Stockholm', 998, 0, 'yes'),
(25, 1, '', 'Malmö', 998, 0, 'no');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_cms`
--

DROP TABLE IF EXISTS `tbl_cms`;
CREATE TABLE `tbl_cms` (
  `pageID` int(11) NOT NULL,
  `pageTitle` varchar(100) DEFAULT NULL,
  `pageSlug` varchar(100) DEFAULT NULL,
  `pageContent` text,
  `pageImage` varchar(100) DEFAULT NULL,
  `pageParentPageID` int(11) DEFAULT '0',
  `dated` timestamp NULL DEFAULT NULL,
  `pageStatus` enum('Inactive','Published') DEFAULT 'Inactive',
  `seoMetaTitle` varchar(100) DEFAULT NULL,
  `seoMetaKeyword` varchar(255) DEFAULT NULL,
  `seoMetaDescription` varchar(255) DEFAULT NULL,
  `seoAllowCrawler` tinyint(1) DEFAULT '1',
  `pageCss` text,
  `pageScript` text,
  `menuTop` tinyint(4) DEFAULT '0',
  `menuBottom` tinyint(4) DEFAULT '0'
) ;

--
-- Vider la table avant d'insérer `tbl_cms`
--

TRUNCATE TABLE `tbl_cms`;
--
-- Contenu de la table `tbl_cms`
--

INSERT INTO `tbl_cms` (`pageID`, `pageTitle`, `pageSlug`, `pageContent`, `pageImage`, `pageParentPageID`, `dated`, `pageStatus`, `seoMetaTitle`, `seoMetaKeyword`, `seoMetaDescription`, `seoAllowCrawler`, `pageCss`, `pageScript`, `menuTop`, `menuBottom`) VALUES
(7, 'About Us', 'about-us.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nSuspendisse quis mi commodo, eleifend massa ut, dapibus ligula.<br />\nMaecenas sagittis sem sed sapien blandit venenatis.<br />\nPraesent eleifend ligula id ex condimentum, eu finibus lorem hendrerit.<br />\nVestibulum consequat nunc a elit faucibus lacinia.<br />\nProin quis libero eget lorem vulputate imperdiet.<br />\nVivamus iaculis arcu eget libero imperdiet, sit amet posuere ante consectetur.', 'about-company1.jpg', 0, '2016-11-27 09:33:43', 'Published', 'About Us', 'About Job Portal, Jobs, IT', 'The leading online job portal', 1, NULL, NULL, 1, 1),
(13, 'How To Get Job', 'how-to-get-job.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', NULL, 0, '2017-08-27 18:50:08', 'Published', 'How To Get Job', 'Tips, Job, Online', 'How to get job includes tips and tricks to crack interview', 1, NULL, NULL, 0, 0),
(14, 'Interview', 'interview.html', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\n<br />\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\n<br />\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\nAliquam imperdiet cursus<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', NULL, 0, '2016-11-27 09:42:22', 'Published', 'Interview', 'job, jobs, interview, tips', 'How to take interview', 1, NULL, NULL, 0, 0),
(15, 'ATT SKRIVA CV', 'cv-writing.html', 'Ett bra och tydligt CV g&ouml;r det m&ouml;jligt f&ouml;r rekryteraren att f&ouml;rst&aring; varf&ouml;r just du &auml;r r&auml;tt f&ouml;r jobbet du vill ha. Att skriva CV p&aring; ett strukturerat s&auml;tt visar dina erfarenheter och kunskaper medan du i ditt personliga brev kan ber&auml;tta mer om vem du &auml;r och varf&ouml;r du passar f&ouml;r tj&auml;nsten du s&ouml;ker. Men vilken information ska egentligen finnas med i ditt CV? Hur l&aring;ngt ska det vara? Och hur strukturerar du det s&aring; det blir l&auml;tt att l&auml;sa? H&auml;r nedanf&ouml;r f&aring;r du bra hj&auml;lp.<br />\r\n<br />\r\n<strong>CV - OLIKA FORMAT</strong><br />\r\nN&auml;r du s&ouml;ker jobb genom oss s&aring; kan du anv&auml;nda ett eget CV som bifogad fil. Eller s&aring; anv&auml;nder du det CV som automatiskt skapas n&auml;r du registrerar ett konto hos oss. Ett tips &auml;r att ocks&aring; g&ouml;ra ditt CV s&ouml;kbart genom fylla i dina uppgifter, erfarenheter och kunskaper direkt under ditt konto.&nbsp;H&auml;r kan du ladda ned en enkel CV-mall&nbsp;som du kan anv&auml;nda som st&ouml;d n&auml;r du skriver ditt eget CV.<br />\r\n<br />\r\n<strong>L&Auml;TT&Ouml;VERSK&Aring;DLIGT CV</strong><br />\r\nEtt grundl&auml;ggande tips &auml;r att ditt CV ska vara l&auml;tt&ouml;versk&aring;dligt och snabbt ge en bild av dig och dina kvalifikationer. Dela upp ditt CV i tydliga rubriker som arbetslivserfarenhet och utbildning och se till att allt &auml;r uppst&auml;llt i kronologisk ordning med dina senaste erfarenheter f&ouml;rst. L&auml;ngden p&aring; ditt CV &auml;r inte avg&ouml;rande s&aring; l&auml;nge strukturen k&auml;nns logisk och informationen &auml;r l&auml;tt att f&ouml;lja. T&auml;nk p&aring; att ditt CV inte ska beskriva dig som person, utan visa p&aring; dina erfarenheter och kunskap.<br />\r\n<br />\r\n<strong>KONTAKTUPPGIFTER</strong><br />\r\nL&auml;gg dina kontaktuppgifter d&auml;r de syns tydligt, h&ouml;gst upp i ditt CV brukar vara en bra plats. De uppgifter som &auml;r bra att ha med &auml;r namn och ett s&auml;tt f&ouml;r oss att n&aring; dig, till exempel telefonnummer eller mailadress.&nbsp;&nbsp;<br />\r\n<br />\r\n<strong>ARBETSLIVSERFARENHET</strong><br />\r\nVilka tidigare tj&auml;nster du skriver med i ditt CV beror p&aring; hur l&aring;ngt i karri&auml;ren du kommit. Om du inte har jobbat s&aring; l&auml;nge, kan all arbetslivserfarenhet vara bra att ta med. Har du d&auml;remot hunnit f&aring; n&aring;gra &aring;rs arbetslivserfarenhet beh&ouml;ver du inte n&auml;mna alla jobb du haft. Plocka med dem som k&auml;nns mest relevanta f&ouml;r den tj&auml;nst du s&ouml;ker. Komplettera f&ouml;retagets namn, tj&auml;nstens titel och perioden du arbetade med en kort beskrivning om vad jobbet innebar. Vad l&auml;rde du dig, vad ansvarade du f&ouml;r och hur s&aring;g dina resultat ut? Den beskrivande delen &auml;r viktig f&ouml;r att rekryteraren ska kunna skaffa sig en uppfattning av hur dina tidigare erfarenheter kan vara aktuella f&ouml;r den tj&auml;nsten du s&ouml;ker. Skriv om din nuvarande eller senaste arbetsgivare &ouml;verst och fyll p&aring; med de andra under.<br />\r\n<br />\r\n<strong>UTBILDNING</strong><br />\r\nH&auml;r g&auml;ller samma regel som f&ouml;r delen om arbetslivserfarenhet, plocka med det som k&auml;nns mest relevant f&ouml;r tj&auml;nsten du s&ouml;ker. B&ouml;rja med att presentera det du studerade senast och g&aring; sedan bak&aring;t i tiden. Om du har en l&auml;ngre utbildning beh&ouml;ver du inte ta med alla delar av dina studier - har du exempelvis en magisterexamen beh&ouml;ver du inte i ditt CV ber&auml;tta var du g&aring;tt i grundskolan &ndash; det viktiga &auml;r att se var du befinner dig idag och dina senaste steg innan dess. &nbsp; Ange skolans namn, vilken ort den finns p&aring;, vilket program eller kurs du l&auml;st och under vilken tidsperiod du studerade. Om du studerar idag s&aring; skriv att din utbildning &auml;r p&aring;g&aring;ende och n&auml;mn vilken examen du planerar att ta.<br />\r\n<br />\r\n<strong>&Ouml;VRIGA MERITER</strong><br />\r\nBeskriv kortfattat dina uppdrag i f&ouml;reningar, k&aring;rer, organisationer eller annat ideellt engagemang. Ber&auml;tta &auml;ven h&auml;r hur dina ansvarsomr&aring;den s&aring;g ut s&aring; att rekryteraren kan f&ouml;rst&aring; varf&ouml;r erfarenheterna du tagit upp i ditt CV kan vara relevanta f&ouml;r tj&auml;nsten du s&ouml;ker.<br />\r\n<br />\r\n<strong>SPR&Aring;KKUNSKAPER</strong><br />\r\nSkriv de spr&aring;k du beh&auml;rskar och gl&ouml;m inte att gradera din kunskap. Ett vanligt s&auml;tt att gradera spr&aring;kkunskaper p&aring; &auml;r; grundl&auml;ggande, goda, mycket goda och flytande. B&ouml;rja med att presentera de spr&aring;k du kan flytande och forts&auml;tt sedan ned&aring;t.<br />\r\n<br />\r\n<strong>&Ouml;VRIGA KOMPETENSER</strong><br />\r\nN&auml;mn de system, program, programmeringsspr&aring;k eller tekniker du beh&auml;rskar. Gl&ouml;m inte att &auml;ven gradera dina kunskaper. Skriv f&ouml;rst de kompetenser du beh&auml;rskar b&auml;st f&ouml;r att ge en tydlig &ouml;verblick. H&auml;r kan du &auml;ven skriva med innehav av k&ouml;rkort om det efterfr&aring;gas i tj&auml;nsten.<br />\r\n<br />\r\n<strong>REFERENSER</strong><br />\r\nI regel r&auml;cker det att du i ditt CV skriver &rdquo;referenser l&auml;mnas g&auml;rna p&aring; beg&auml;ran&rdquo;. T&auml;nk igenom vilka personer som kan beskriva dig och dina f&auml;rdigheter p&aring; ett bra s&auml;tt. Det kan exempelvis vara tidigare chefer, kollegor eller handledaren fr&aring;n utbildningen. St&auml;m alltid av med de personer du l&auml;mnar som referenser s&aring; att de &auml;r f&ouml;rberedda p&aring; att bli kontaktade av rekryteraren. L&auml;s fler referenstips fr&aring;n rekryterare p&aring; v&aring;r blogg.<br />\r\n<br />\r\n<strong>LAYOUT</strong><br />\r\nDet allra viktigaste &auml;r att ditt CV &auml;r l&auml;tt&ouml;versk&aring;dligt och enkelt f&ouml;r rekryteraren att f&ouml;rst&aring;. S&aring; l&auml;gg lagom med tid och engagemang p&aring; det grafiska utseendet. Satsa ist&auml;llet p&aring; att l&auml;sa igenom ditt CV en extra g&aring;ng f&ouml;r att undvika on&ouml;diga stavfel!<br />\r\n<br />\r\n<strong>SKRIV ETT PERSONLIGT BREV</strong><br />\r\nDitt personliga brev &auml;r ett bra komplement till ditt CV och det ger dig m&ouml;jlighet att tydligare beskriva dig som person, dina styrkor, m&aring;l och ambitioner. Det &auml;r framf&ouml;rallt h&auml;r du ska motivera varf&ouml;r du s&ouml;ker den utannonserade tj&auml;nsten.&nbsp;<br />\r\n<br />\r\nSource:&nbsp;https://www.academicwork.se/att-skriva-cv', NULL, 0, '2018-01-25 18:14:45', 'Published', 'CV writing tips and tricks', 'CV, resume', 'How to write a professional CV.', 1, NULL, NULL, NULL, NULL),
(16, 'Privacy Policy', 'privacy-policy.html', '1Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.<br />\r\n<br />\r\nAliquam imperdiet cursus felis, sed posuere nunc. In sollicitudin accumsan orci, eu aliquet lectus tempus nec. Fusce facilisis metus a diam dignissim tristique. Fusce id ligula lectus. In tempor ut purus vel pharetra. Quisque ultrices justo id lectus tristique finibus. Praesent facilisis velit eu elementum tempus. In vel lectus congue, ultricies orci congue, imperdiet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sollicitudin, magna ultricies vulputate feugiat, tortor arcu dignissim urna, vitae porta sem justo ut enim. Donec ullamcorper tellus vel fringilla varius. In nec felis quam. Quisque ut nunc non dui bibendum tristique quis accumsan libero.<br />\r\n<br />\r\nNunc finibus nisi id nisi scelerisque eleifend. Sed vulputate finibus vestibulum. Nulla facilisi. Etiam convallis leo nisl, et hendrerit ligula ornare ut. Nunc et enim ultrices, vehicula dui sit amet, fringilla tellus. Quisque eu elit lorem. Nunc hendrerit orci ut ex molestie, eget semper lorem cursus. Proin congue consectetur felis et cursus. Sed aliquam nunc nec odio ultricies, eget aliquet nisl porta. Phasellus consequat eleifend enim. Donec in tincidunt diam, id mattis nulla. Cras in luctus arcu, eu efficitur mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tincidunt sapien libero, sit amet convallis tortor sollicitudin non. Sed id nulla ac nulla volutpat vehicula. Morbi lacus nunc, tristique rutrum molestie vel, tincidunt ut lectus.<br />\r\nAliquam imperdiet cursus<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, dolor non vulputate pretium, nisl enim posuere leo, vel dictum orci dolor non est. Sed lacus lorem, pulvinar sit amet hendrerit a, varius eu est. Fusce ut turpis enim. Sed vel gravida velit, vel vulputate tortor. Suspendisse ut congue sem, vitae dignissim nulla. In at neque sagittis, pulvinar risus sit amet, tincidunt enim. Proin placerat lorem nisl, a molestie sem ornare quis. Duis bibendum, lectus et rhoncus auctor, massa dolor efficitur risus, a hendrerit quam nulla ut enim. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', NULL, 0, '2017-08-19 22:15:22', 'Published', 'Privacy Policy', 'Privacy, policies', 'Job portal privacy policies', 1, NULL, NULL, NULL, NULL),
(17, 'Privacy Notice', 'privacy-notice.html', '<html>\r\n<body>\r\nBy ticking this box, you confirm that you have read the <a href="./terms .html">terms and conditions</a>, that you understand them and that you agree to be bound by them. <br/>\r\nFor more about how we use your information, see our <a href="">privacy notice</a>\r\n</body></html>', NULL, 0, '2018-01-25 20:45:43', 'Published', 'Privacy Notice', 'Privacy,Notice', 'Privacy Notice to use BiXma', 1, NULL, NULL, NULL, NULL),
(18, 'test', 'test.html', '<div style=\'width: 700px;max-width: 700px;\n    margin: auto;\' id=\'canvas\'>\n        <div class=\'companyinfoWrp\'>\n\n        <h1 class=\'jobname\'>Developer</h1>\n        <div class=\'jobthumb\'><img src=\'http://vps47202.lws-hosting.com/public/uploads/employer/JOBPORTAL-1516898144.png\' /></div>\n        <div class=\'jobloc\'><h3>Bixma</h3>\n        </div>\n        <div class=\'clear\'></div>\n        </div>\n        </div>', NULL, 0, '2018-01-27 10:51:54', 'Published', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_companies`
--

DROP TABLE IF EXISTS `tbl_companies`;
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
) ;

--
-- Vider la table avant d'insérer `tbl_companies`
--

TRUNCATE TABLE `tbl_companies`;
--
-- Contenu de la table `tbl_companies`
--

INSERT INTO `tbl_companies` (`ID`, `company_name`, `company_email`, `company_ceo`, `industry_ID`, `ownership_type`, `company_description`, `company_location`, `no_of_offices`, `company_website`, `no_of_employees`, `established_in`, `company_type`, `company_fax`, `company_phone`, `company_logo`, `company_folder`, `company_country`, `sts`, `company_city`, `company_slug`, `old_company_id`, `old_employerlogin`, `flag`, `ownership_type`) VALUES
(209, 'Bixma', NULL, NULL, 22, 'Private', 'IT company', 'Stockholn', NULL, 'www.bixma.com', '11-50', NULL, NULL, NULL, '0046700775775', 'JOBPORTAL-1516898144.png', NULL, NULL, 'active', NULL, 'bixma', NULL, NULL, NULL, 'Private'),
(210, 'Travos AB', NULL, NULL, 35, 'Private', 'Utbildning och arbetsmarknadsinsatser.', 'Centralvägen 1, 171 68 Solna', NULL, 'www.travos.se', '1-10', NULL, NULL, NULL, '+3221498347928', 'JOBPORTAL-1516916861.jpeg', NULL, NULL, 'active', NULL, 'travos-ab', NULL, NULL, NULL, 'Private'),
(211, 'Attunda tingsrätt', NULL, NULL, 42, 'Private', 'Attunda tingsrätt bildades den 1 april 2007. Tingsrätten är en sammanslagning av Sollentuna och Södra Roslags tingsrätter, exklusive Lidingö kommun som numer tillhör Stockholms tingsrätt.\r\nAttunda tingsrätt är sedan den 12 april 2010 beläget i ett nybyggt tingshus vid Sollentuna centrum. Verksamheten vid de två tidigare kansliorterna Gärdet och Sollentuna upphörde vid samma tidpunkt.', 'Tingsvägen 11,  191 61 Sollentuna', NULL, 'www.attundatingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990014.jpg', NULL, NULL, 'active', NULL, 'attunda-tingsrtt', NULL, NULL, NULL, 'Government'),
(212, 'Göteborgs tingsrätt', NULL, NULL, 42, 'Private', 'Vid Göteborgs tingsrätt tjänstgör omkring 210 personer. Tingsrätten är uppdelad i fyra avdelningar som handlägger både brottmål och tvistemål samt eko-brottmål. Dessutom har tingsrätten en konkursenhet.', 'Ullevigatan 15', NULL, 'www.goteborgstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990431.png', NULL, NULL, 'active', NULL, 'gteborgs-tingsrtt', NULL, NULL, NULL, 'Government'),
(213, 'Jönköpings tingsrätt', NULL, NULL, 42, 'Private', 'Sveriges Domstolar är samlingsnamnet för domstolarnas verksamhet. Sveriges Domstolar omfattar de allmänna domstolarna, de allmänna förvaltningsdomstolarna, hyres- och arrendenämnderna, Rättshjälpsmyndigheten, Rättshjälpsnämnden och Domstolsverket.', 'Hamngatan 15, 553 16 Jönköping', NULL, 'www.jonkopingstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516990788.png', NULL, NULL, 'active', NULL, 'jnkpings-tingsrtt', NULL, NULL, NULL, 'Government'),
(214, 'Linköpings tingsrätt', NULL, NULL, 42, 'Private', 'Tingsrätten handlägger bland annat brottmål, tvistemål och familjerättsliga mål. Vi handlägger också konkurser och ansökningar om till exempel god man och bodelningsförrättare.', 'Brigadgatan 3, 587 58 Linköping', NULL, 'www.linkopingstingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991082.png', NULL, NULL, 'active', NULL, 'linkpings-tingsrtt', NULL, NULL, NULL, 'Government'),
(215, 'Eskilstuna tingsrätt', NULL, NULL, 42, 'Private', 'Tingsrätten har 40 anställda. Domsagan omfattar Eskilstuna och Strängnäs kommuner med en sammanlagd befolkningsmängd av drygt 130 000 invånare. Tingsrätten är organiserad i två målenheter och en administrativ enhet. Varje målenhet har en samordnande rådman. Till målenhet 1 hör också konkursavdelningen.', 'Rademachergatan 8 632 20 Eskilstuna', NULL, 'www.eskilstunatingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991298.png', NULL, NULL, 'active', NULL, 'eskilstuna-tingsrtt', NULL, NULL, NULL, 'Government'),
(216, 'Malmö Tingsrätt', NULL, NULL, 42, 'Private', 'Malmö tingsrätt är en allmän domstol som handlägger brottmål, tvistemål, ärenden och konkurser. Tingsrätten är sjörättsdomstol med domkrets enligt sjölagen och domstol i tryckfrihetsmål, yttrandefrihetsmål och mål enligt lagen (2002:599) om grupprättegång m m i Skåne län. Tingsrätten är organiserad i fyra målavdelningar och en administrativ enhet och har ca 150 anställda.', 'Kalendegatan 1, 211 35 Malmö', NULL, 'www.malmotingsratt.domstol.se', '1-10', NULL, NULL, NULL, '0723189657', 'JOBPORTAL-1516991464.png', NULL, NULL, 'active', NULL, 'malm-tingsrtt', NULL, NULL, NULL, 'Government');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_conversation`
--

DROP TABLE IF EXISTS `tbl_conversation`;
CREATE TABLE `tbl_conversation` (
  `id_conversation` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_conversation`
--

TRUNCATE TABLE `tbl_conversation`;
--
-- Contenu de la table `tbl_conversation`
--

INSERT INTO `tbl_conversation` (`id_conversation`, `id_employer`, `id_job_seeker`, `created_at`) VALUES
(3, 209, 423, '2018-01-25 10:36:22'),
(4, 209, 425, '2018-01-26 12:28:04'),
(5, 216, 427, '2018-01-26 13:17:54'),
(6, 209, 427, '2018-01-26 13:40:46'),
(7, 215, 430, '2018-01-28 05:09:27'),
(8, 211, 430, '2018-01-28 05:09:39'),
(9, 213, 430, '2018-01-28 05:09:45');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_conv_message`
--

DROP TABLE IF EXISTS `tbl_conv_message`;
CREATE TABLE `tbl_conv_message` (
  `id_conv_message` int(11) NOT NULL,
  `id_conversation` int(11) DEFAULT NULL,
  `id_sender` int(11) DEFAULT NULL,
  `message` text,
  `type_sender` varchar(50) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT '0',
  `seen_at` datetime DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_conv_message`
--

TRUNCATE TABLE `tbl_conv_message`;
--
-- Contenu de la table `tbl_conv_message`
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
(34, 8, 211, 'Hej!', 'employers', 0, NULL, '2018-01-28 06:19:32');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_countries`
--

DROP TABLE IF EXISTS `tbl_countries`;
CREATE TABLE `tbl_countries` (
  `ID` int(11) NOT NULL,
  `country_name` varchar(150) NOT NULL DEFAULT '',
  `country_citizen` varchar(150) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_countries`
--

TRUNCATE TABLE `tbl_countries`;
--
-- Contenu de la table `tbl_countries`
--

INSERT INTO `tbl_countries` (`ID`, `country_name`, `country_citizen`) VALUES
(8, 'Sweden', 'Swedish');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_email_content`
--

DROP TABLE IF EXISTS `tbl_email_content`;
CREATE TABLE `tbl_email_content` (
  `ID` int(11) NOT NULL,
  `email_name` varchar(155) DEFAULT NULL,
  `from_name` varchar(155) DEFAULT NULL,
  `content` text,
  `from_email` varchar(90) DEFAULT NULL,
  `subject` varchar(155) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_email_content`
--

TRUNCATE TABLE `tbl_email_content`;
--
-- Contenu de la table `tbl_email_content`
--

INSERT INTO `tbl_email_content` (`ID`, `email_name`, `from_name`, `content`, `from_email`, `subject`) VALUES
(1, 'Forgot Password', 'MNO Jobs', '<style type="text/css">\n				.txt {\n						font-family: Arial, Helvetica, sans-serif;\n						font-size: 13px; color:#000000;\n					}\n				</style>\n<p class="txt">Thank you  for contacting Member Support. Your account information is listed below: </p>\n<table border="0" cellspacing="0" cellpadding="0" width="600" class="txt">\n  <tr>\n    <td width="17" height="19"><p>&nbsp;</p></td>\n    <td width="159" height="25" align="right"><strong>Login Page:&nbsp;&nbsp;</strong></td>\n    <td width="424" align="left"><a href="{SITE_URL}/login">{SITE_URL}/login</a></td>\n  </tr>\n  <tr>\n    <td height="19">&nbsp;</td>\n    <td height="25" align="right"><strong>Your Username:&nbsp;&nbsp;</strong></td>\n    <td align="left">{USERNAME}</td>\n  </tr>\n  <tr>\n    <td height="19"><p>&nbsp;</p></td>\n    <td height="25" align="right"><strong>Your Password:&nbsp;&nbsp;</strong></td>\n    <td align="left">{PASSWORD}</td>\n  </tr>\n</table>\n\n<p class="txt">Thank you,</p>', 'service@jobportalbeta.com', 'Password Recovery'),
(2, 'Jobseeker Signup', 'Jobseeker Signup Successful', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\n\n  <p>{JOBSEEKER_NAME}:</p>\n  <p>Thank you for joining us. Please note your profile details for future record.</p>\n  <p>Username: {USERNAME}<br>\n    Password: {PASSWORD}</p>\n  \n  <p>Regards</p>', 'service@jobportalbeta.com', 'Jobs website'),
(3, 'Employer signs up', 'Employer Signup Successful', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\n\n  <p>{EMPLOYER_NAME}</p>\n  <p>Thank you for joining us. Please note your profile details for future record.</p>\n  <p>Username: {USERNAME}<br>\n    Password: {PASSWORD}</p>\n  <p>Regards</p>', 'service@jobportalbeta.com', 'Jobs website'),
(4, 'New job is posted by Employer', 'New Job Posted', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\n\n  <p>{JOBSEEKER_NAME},</p>\n  <p>We would like to inform  that a new job has been posted on our website that may be of your interest.</p>\n  <p>Please visit the  following link to review and apply:</p>\n <p>{JOB_LINK}</p>\n  <p>Regards,</p>', 'service@jobportalbeta.com', 'New {JOB_CATEGORY}'),
(5, 'Apply Job', 'Job Application', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\n  <p>{EMPLOYER_NAME}:</p>\n  <p>A new candidate has applied for the post of {JOB_TITLE}.</p>\n  <p>Please visit the following link to review the applicant profile.<br>\n    {CANDIDATE_PROFILE_LINK}</p>\n  <p>Regards,</p>', 'service@jobportalbeta.com', 'New Job CV {JOB_TITLE}'),
(6, 'Job Activation Email', 'Job Activated', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\n  <p>{EMPLOYER_NAME}:</p>\n  <p>You had recently posted a job: {JOB_TITLE} on our website.</p>\n  <p>Your recent job has been approved and should be displaying on our website.</p>\n  <p>Thank you for using our website.</p>\n  <p>Regards,</p>', 'service@jobportalbeta.com', '{JOB_TITLE}  is now active'),
(7, 'Send Message To Candidate', '{EMPLOYER_NAME}', '<style type="text/css">p {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color:#000000;}</style>\r\n  <p>Hi {JOBSEEKER_NAME}:</p>\r\n  <p>A new message has been posted for you by :  {COMPANY_NAME}.</p>\r\n  <p>Message:</p>\r\n  <p>{MESSAGE}</p>\r\n  <p>You may review this company by going to: {COMPANY_PROFILE_LINK} to company profile.</p>\r\n  \r\n  <p>Regards,</p>', '{EMPLOYER_EMAIL}', 'New message for you'),
(8, 'Scam Alert', '{JOBSEEKER_NAME}', 'bla bla bla', '{JOBSEEKER_EMAIL}', 'Company reported');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_employers`
--

DROP TABLE IF EXISTS `tbl_employers`;
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
  `top_employer` enum('no','yes') DEFAULT 'no'
) ;

--
-- Vider la table avant d'insérer `tbl_employers`
--

TRUNCATE TABLE `tbl_employers`;
--
-- Contenu de la table `tbl_employers`
--

INSERT INTO `tbl_employers` (`ID`, `company_ID`, `email`, `pass_code`, `first_name`, `last_name`, `country`, `city`, `mobile_phone`, `gender`, `dated`, `sts`, `dob`, `home_phone`, `verification_code`, `first_login_date`, `last_login_date`, `ip_address`, `old_emp_id`, `flag`, `present_address`, `top_employer`) VALUES
(209, 209, 'bixmatech@gmail.com', 'test123', 'Bixma', NULL, 'Sweden', 'Stockholm', '0046700775775', NULL, '2018-01-25', 'active', NULL, NULL, NULL, '2018-01-25 10:45:06', '2018-01-28 07:17:41', '90.224.199.144', NULL, NULL, NULL, 'yes'),
(210, 210, 'ayoub.ezzini3@gmail.com', 'ayoub123', 'Timéo Skarander', NULL, 'Sweden', 'N.A', '+23123140938', NULL, '0000-00-00', 'active', NULL, NULL, NULL, '2018-01-27 09:24:51', '2018-01-28 06:19:09', '105.71.136.97', NULL, NULL, NULL, 'yes'),
(211, 211, 'info@travos.se', 'mimo123', 'Attunda Tingsrätt', NULL, 'Sweden', 'Sollentuna', '0723189657', NULL, '0000-00-00', 'active', NULL, NULL, NULL, '2018-01-26 12:08:58', '2018-01-28 04:15:33', '83.183.12.57', NULL, NULL, NULL, 'yes'),
(212, 212, 'mimosweden@gmail.com', 'mimo123', 'Göteborgs tingsrätt', NULL, 'Sweden', 'Göteborg', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(213, 213, 'libanesen@hotmail.com', 'mimo123', 'Jönköpings tingsrätt', NULL, 'Sweden', 'Jönköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-27 07:27:49', '2018-01-28 04:14:51', '83.183.12.57', NULL, NULL, NULL, 'yes'),
(214, 214, 'timeo.skarander@hotmail.com', 'mimo123', 'Linköpings tingsrätt', NULL, 'Sweden', 'Linköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(215, 215, 'rekrytering@travos.se', 'mimo123', 'Eskilstuna tingsrätt', NULL, 'Sweden', 'Eskilstuna', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-28 04:14:32', '2018-01-28 04:14:32', '83.183.12.57', NULL, NULL, NULL, 'yes'),
(216, 216, 'sfi@travos.se', 'mimo123', 'Malmö Tingsrätt', NULL, 'Sweden', 'Malmö', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_favourite_candidates`
--

DROP TABLE IF EXISTS `tbl_favourite_candidates`;
CREATE TABLE `tbl_favourite_candidates` (
  `employer_id` int(11) NOT NULL,
  `seekerid` int(11) DEFAULT NULL,
  `employerlogin` varchar(255) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_favourite_candidates`
--

TRUNCATE TABLE `tbl_favourite_candidates`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_favourite_companies`
--

DROP TABLE IF EXISTS `tbl_favourite_companies`;
CREATE TABLE `tbl_favourite_companies` (
  `seekerid` int(11) NOT NULL,
  `companyid` int(11) DEFAULT NULL,
  `seekerlogin` varchar(255) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_favourite_companies`
--

TRUNCATE TABLE `tbl_favourite_companies`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_gallery`
--

DROP TABLE IF EXISTS `tbl_gallery`;
CREATE TABLE `tbl_gallery` (
  `ID` int(11) NOT NULL,
  `image_caption` varchar(150) DEFAULT NULL,
  `image_name` varchar(155) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `sts` enum('inactive','active') DEFAULT 'active'
) ;

--
-- Vider la table avant d'insérer `tbl_gallery`
--

TRUNCATE TABLE `tbl_gallery`;
--
-- Contenu de la table `tbl_gallery`
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
-- Structure de la table `tbl_institute`
--

DROP TABLE IF EXISTS `tbl_institute`;
CREATE TABLE `tbl_institute` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sts` enum('blocked','active') DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_institute`
--

TRUNCATE TABLE `tbl_institute`;
--
-- Contenu de la table `tbl_institute`
--

INSERT INTO `tbl_institute` (`ID`, `name`, `sts`) VALUES
(1, 'ANTS', NULL),
(2, 'test', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_alert`
--

DROP TABLE IF EXISTS `tbl_job_alert`;
CREATE TABLE `tbl_job_alert` (
  `ID` int(11) NOT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_job_alert`
--

TRUNCATE TABLE `tbl_job_alert`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_alert_queue`
--

DROP TABLE IF EXISTS `tbl_job_alert_queue`;
CREATE TABLE `tbl_job_alert_queue` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_job_alert_queue`
--

TRUNCATE TABLE `tbl_job_alert_queue`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_functional_areas`
--

DROP TABLE IF EXISTS `tbl_job_functional_areas`;
CREATE TABLE `tbl_job_functional_areas` (
  `ID` int(7) NOT NULL,
  `industry_ID` int(7) DEFAULT NULL,
  `functional_area` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active'
) ;

--
-- Vider la table avant d'insérer `tbl_job_functional_areas`
--

TRUNCATE TABLE `tbl_job_functional_areas`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_industries`
--

DROP TABLE IF EXISTS `tbl_job_industries`;
CREATE TABLE `tbl_job_industries` (
  `ID` int(11) NOT NULL,
  `industry_name` varchar(155) DEFAULT NULL,
  `slug` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active',
  `top_category` enum('no','yes') DEFAULT 'no'
) ;

--
-- Vider la table avant d'insérer `tbl_job_industries`
--

TRUNCATE TABLE `tbl_job_industries`;
--
-- Contenu de la table `tbl_job_industries`
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
-- Structure de la table `tbl_job_seekers`
--

DROP TABLE IF EXISTS `tbl_job_seekers`;
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
  `send_job_alert` enum('no','yes') DEFAULT 'yes'
) ;

--
-- Vider la table avant d'insérer `tbl_job_seekers`
--

TRUNCATE TABLE `tbl_job_seekers`;
--
-- Contenu de la table `tbl_job_seekers`
--

INSERT INTO `tbl_job_seekers` (`ID`, `first_name`, `last_name`, `email`, `password`, `present_address`, `permanent_address`, `dated`, `country`, `city`, `gender`, `dob`, `phone`, `photo`, `default_cv_id`, `mobile`, `home_phone`, `cnic`, `nationality`, `career_objective`, `sts`, `verification_code`, `first_login_date`, `last_login_date`, `slug`, `ip_address`, `old_id`, `flag`, `queue_email_sts`, `send_job_alert`) VALUES
(8, 'Test Test', NULL, 'testtest123@gmail.com', 'testtest', 'here', NULL, '2016-03-12 01:44:43', 'Pakistan', 'Islamabad', 'male', '1990-01-01', NULL, 'test-test-JOBPORTAL-8.jpg', 0, '123123123', '123123123', NULL, '1', NULL, 'active', NULL, '2016-05-14 15:39:15', '2017-05-04 05:12:02', NULL, '2.50.150.100', NULL, NULL, NULL, 'yes'),
(9, 'Michel Jen', '', 'qwert@test.com', 'test123', 'n eu mattis mauris. Fusce fringilla imperdiet enim', '', '2016-03-12 01:51:56', 'United States', 'Malmö', 'male', '1988-04-09', NULL, 'no-image.jpg', 0, '123456789', '123456789', NULL, 'United States', NULL, 'active', NULL, '2018-01-25 09:45:14', '2018-01-27 09:08:44', NULL, '115.186.165.234', NULL, NULL, NULL, 'yes'),
(10, 'Jhony Man', '', 'etest@test.com', 'test123', 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl,', NULL, '2016-03-12 13:04:32', 'United States', 'Las Vegas', 'other', '1989-04-04', NULL, 'no-image.jpg', 0, '123456897', '', NULL, 'United States', NULL, 'active', NULL, '2018-01-24 16:40:19', '2018-01-27 05:57:29', NULL, '115.186.165.234', NULL, NULL, NULL, 'yes'),
(11, 'Kganxx', '', 'kganxx@gmail.com', 'Solutions123', 'PO Box 450125', NULL, '2016-03-28 14:11:09', 'Sweden', 'Malmö', 'male', '1988-05-31', NULL, 'no-image.jpg', 0, '152485145', '', NULL, 'United Arab Emirates', NULL, 'active', NULL, '2016-03-28 14:13:41', '2016-03-28 14:13:41', NULL, '2.49.65.117', NULL, NULL, NULL, 'yes'),
(12, 'KAcykos', NULL, 'kacykos1@gmail.com', 'kacper93', 'adadad', NULL, '2016-03-28 14:46:29', 'Pakistan', 'Abu Dhabi', 'male', '1980-11-14', NULL, 'no-image.jpg', 0, '23242424', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '83.27.161.159', NULL, NULL, NULL, 'yes'),
(13, 'ajay', NULL, 'jainmca4444@gmail.com', 'red@12321', 'ETS', NULL, '2016-03-28 17:40:38', 'Pakistan', 'Lahore', 'male', '1980-04-09', NULL, 'no-image.jpg', 0, '898989899', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '112.196.142.218', NULL, NULL, NULL, 'yes'),
(14, 'Peter Sturm', NULL, 'petersturm@bluewin.ch', 'petertester', 'Via Cantone', NULL, '2016-03-28 18:18:22', 'United States', 'new york', 'male', '1980-01-01', NULL, 'no-image.jpg', 0, '678768768768', '', NULL, 'United States', NULL, 'active', NULL, NULL, NULL, NULL, '46.127.154.34', NULL, NULL, NULL, 'yes'),
(411, 'gfgfgfhh', NULL, 'hassanayoub85@hotmail.com', 'zaq12wsx', 'dsfdgfghhghgfh', NULL, '2018-01-25 09:49:27', 'Australia', 'fdfdf', 'male', '1984-05-01', NULL, NULL, 0, '0000000', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '185.118.27.136', NULL, NULL, NULL, 'yes'),
(422, 'a', NULL, 'a@a.a', '123456', 'a', NULL, '2018-01-25 10:07:35', 'Australia', 'a', 'male', '1985-04-15', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '41.142.0.106', NULL, NULL, NULL, 'yes'),
(423, 'Ram', '', 'mailramzi@gmail.com', 'test123', 'Sweden', NULL, '2018-01-25 10:27:02', 'Sweden', 'Linköping', 'male', '1979-02-27', NULL, NULL, 0, '0046700775775', '', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-25 10:31:27', '2018-01-28 05:20:54', NULL, '90.224.199.144', NULL, NULL, NULL, 'yes'),
(424, 'Ayoub Ezzini', '', 'a37killer@gmail.com', 'ayoub123', 'N/A', NULL, '2018-01-25 14:08:33', 'Sweden', 'Göteborg', 'male', '1997-09-06', NULL, 'ayoub-ezzini-JOBPORTAL-424.jpg', 0, '+212623357087', '', NULL, 'United Kingdom', NULL, 'active', NULL, '2018-01-27 08:39:44', '2018-01-28 08:40:35', NULL, '105.71.136.97', NULL, NULL, NULL, 'yes'),
(425, 'Kali Linux', '', 'ayoub.ezzini@gmail.com', '123456', 'Centralvägen 1, 171 68 Solna', NULL, '2018-01-26 06:02:03', 'Sweden', 'Eskilstuna', 'other', '1993-08-20', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '105.156.230.57', NULL, NULL, NULL, 'yes'),
(426, 'Ramtaniii', '', 'ram@gmail.com', 'test123', 'Centralvägen 1, 171 68 Solna', 'ghjkl;', '2018-01-26 12:31:56', 'Sweden', 'Malmö', 'male', '1980-04-05', NULL, NULL, 0, '763356790', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '90.224.199.144', NULL, NULL, NULL, 'yes'),
(428, 'Fredrik Öhrn', '', 'fredrik@ohrn.cc', 'qwerty', 'Vitoxelvägen 17', NULL, '2018-01-28 04:44:03', 'Sweden', 'Sydkoster', 'male', '1981-08-20', NULL, NULL, 0, '0703592426', '0703592426', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-28 05:16:31', '2018-01-28 05:16:31', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(427, 'Tim S', NULL, 'sfi@travos.se', 'mimo123', 'Centralvägen 1', NULL, '2018-01-26 13:01:10', 'Sweden', 'Solna', 'male', '1976-10-04', NULL, NULL, 0, '0723189657', '0723189657', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-26 13:26:31', '2018-01-28 04:14:07', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(429, 'Johan Gustafsson', NULL, 'timeo.skarander@dmediac.se', 'tim123', 'Finlandsgatan 52, 164 53 Kista', NULL, '2018-01-28 04:44:44', 'Sweden', 'KIsta', 'male', '1990-11-04', NULL, NULL, 0, '0723189657', '0046723189657', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(430, 'William Schwarz', '', 'schwarz@gmail.com', 'Pennor99', 'Lotsvägen 17', '', '2018-01-28 04:44:50', 'Sweden', '18166', 'male', '1996-12-20', NULL, 'william-schwarz-BiXma-430.png', 0, '+46735448155', '+46735448155', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-28 05:17:37', '2018-01-28 05:17:37', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(431, 'a', NULL, 'admin@admin.com', 'aabb1234', 's', NULL, '2018-01-28 08:50:57', 'Sweden', 'k', 'male', '1980-09-16', NULL, NULL, 0, 'k', 'k', NULL, 'Swedish', NULL, 'active', NULL, NULL, NULL, NULL, '196.65.146.10', NULL, NULL, NULL, 'yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_titles`
--

DROP TABLE IF EXISTS `tbl_job_titles`;
CREATE TABLE `tbl_job_titles` (
  `ID` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_job_titles`
--

TRUNCATE TABLE `tbl_job_titles`;
--
-- Contenu de la table `tbl_job_titles`
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
-- Structure de la table `tbl_newsletter`
--

DROP TABLE IF EXISTS `tbl_newsletter`;
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
) ;

--
-- Vider la table avant d'insérer `tbl_newsletter`
--

TRUNCATE TABLE `tbl_newsletter`;
-- --------------------------------------------------------

--
-- Structure de la table `tbl_post_jobs`
--

DROP TABLE IF EXISTS `tbl_post_jobs`;
CREATE TABLE `tbl_post_jobs` (
  `ID` int(11) NOT NULL,
  `employer_ID` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_ID` int(11) NOT NULL,
  `industry_ID` int(11) NOT NULL,
  `pay` varchar(60) NOT NULL,
  `dated` date NOT NULL,
  `sts` enum('inactive','pending','blocked','active') NOT NULL DEFAULT 'pending',
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
  `quizz_text` text,
  `answer_1` varchar(255) DEFAULT NULL,
  `answer_2` varchar(255) DEFAULT NULL,
  `answer_3` varchar(255) DEFAULT NULL,
  `advertise` text
) ;

--
-- Vider la table avant d'insérer `tbl_post_jobs`
--

TRUNCATE TABLE `tbl_post_jobs`;
--
-- Contenu de la table `tbl_post_jobs`
--

INSERT INTO `tbl_post_jobs` (`ID`, `employer_ID`, `job_title`, `company_ID`, `industry_ID`, `pay`, `dated`, `sts`, `is_featured`, `country`, `last_date`, `age_required`, `qualification`, `experience`, `city`, `job_mode`, `vacancies`, `job_description`, `contact_person`, `contact_email`, `contact_phone`, `viewer_count`, `job_slug`, `ip_address`, `flag`, `old_id`, `required_skills`, `email_queued`, `quizz_text`, `answer_1`, `answer_2`, `answer_3`, `advertise`) VALUES
(1, 1, 'Web Designer', 1, 22, '81000-100000', '2016-03-11', 'blocked', 'yes', 'United States', '2016-07-11', '', 'BA', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex.', '', '', '', 0, 'mega-technologies-jobs-in-new york-web-designer-1', '115.186.165.234', NULL, NULL, 'css, html, js, jquery', 0, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Php Developer', 1, 22, '41000-50000', '2016-03-11', 'blocked', 'yes', 'United States', '2018-01-11', '', 'MA', '3', 'New York', 'Full Time', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex.', '', '', '', 0, 'mega-technologies-jobs-in-new york-php-developer-2', '115.186.165.234', NULL, NULL, 'php, js, jquery, html', 0, NULL, NULL, NULL, NULL, NULL),
(3, 2, 'Java Developer', 2, 22, '16000-20000', '2016-03-11', 'blocked', 'yes', 'United States', '2016-07-11', '', 'BA', '2', 'New York', 'Part Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in. Nulla at viverra metus, id porttitor nulla. In et arcu id felis eleifend auctor vitae a justo. Nullam eleifend, purus id hendrerit tempus, massa elit vehicula metus, pharetra elementum lectus elit ac felis. Sed fermentum luctus aliquet. Vestibulum pulvinar ornare ipsum, gravida condimentum nulla luctus sit amet. Sed tempor eros a tempor faucibus. Proin orci tortor, placerat sit amet elementum sit amet, ornare vel urna.', '', '', '', 0, 'it-pixels-jobs-in-new york-java-developer-3', '115.186.165.234', NULL, NULL, 'js, php, html, css', 0, NULL, NULL, NULL, NULL, NULL),
(4, 3, 'Dot Net Developer', 3, 22, '61000-70000', '2016-03-11', 'blocked', 'yes', 'Australia', '2016-07-11', '', 'Certification', '4', 'Sydney', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'info-technologies-jobs-in-sydney-dot-net-developer-4', '115.186.165.234', NULL, NULL, '.net, mysql, php, html, css', 0, NULL, NULL, NULL, NULL, NULL),
(5, 4, 'Front End Developer', 4, 22, '61000-70000', '2016-03-11', 'blocked', 'no', 'China', '2016-07-11', '', 'BS', 'Fresh', 'Hong Kong', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'some-it-company-jobs-in-hong kong-front-end-developer-5', '115.186.165.234', NULL, NULL, 'html, css, js, jquery, owl, photoshop', 0, NULL, NULL, NULL, NULL, NULL),
(6, 5, 'Head Of Digital Marketing', 5, 5, '21000-25000', '2016-03-11', 'blocked', 'no', 'United Arab Emirates', '2016-07-11', '', 'MS', 'Fresh', 'Dubai', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'abc-it-tech-jobs-in-dubai-head-of-digital-marketing-6', '101.50.114.8', NULL, NULL, 'html, seo, social media', 0, NULL, NULL, NULL, NULL, NULL),
(7, 6, 'Graphic Designer Adobe Indesign Expert', 6, 22, 'Trainee Stipend', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'BS', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'def-it-company-jobs-in-new york-graphic-designer-adobe-indesign-expert-7', '101.50.114.8', NULL, NULL, 'photoshop, illustrator, indesign, css, html', 0, NULL, NULL, NULL, NULL, NULL),
(8, 7, 'Teachers And Administration Staff', 7, 5, '41000-50000', '2016-03-11', 'blocked', 'yes', 'United Arab Emirates', '2016-07-11', '', 'Certification', '3', 'Dubai', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'ghi-company-jobs-in-dubai-teachers-and-administration-staff-8', '101.50.114.8', NULL, NULL, 'marketing', 0, NULL, NULL, NULL, NULL, NULL),
(9, 8, 'Graphic Designer', 8, 22, '36000-40000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'Diploma', '1', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'jkl-company-jobs-in-new york-graphic-designer-9', '101.50.114.8', NULL, NULL, 'photoshop, illustrator, indesign, html, css', 0, NULL, NULL, NULL, NULL, NULL),
(10, 9, 'Front End Developers', 9, 22, '61000-70000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'Certification', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mno-company-jobs-in-new york-front-end-developers-10', '101.50.114.8', NULL, NULL, 'html, css, jquery, js', 0, NULL, NULL, NULL, NULL, NULL),
(11, 10, 'Seo Specialist', 10, 5, '36000-40000', '2016-03-11', 'blocked', 'no', 'Pakistan', '2016-07-11', '', 'BE', '4', 'Islamabad', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mnt-comapny-jobs-in-islamabad-seo-specialist-11', '101.50.114.8', NULL, NULL, 'seo, sem, smm, google adward', 0, NULL, NULL, NULL, NULL, NULL),
(12, 11, 'Web Design / Frontend Developer', 11, 16, '51000-60000', '2016-03-11', 'blocked', 'no', 'United States', '2016-07-11', '', 'BA', '3', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis. Maecenas vitae ipsum sed risus viverra volutpat non ac sapien. Donec viverra massa at dolor imperdiet hendrerit. Nullam quis est vitae dui placerat posuere. Phasellus eget erat sit amet lacus semper consectetur. Sed a nisi nisi. Pellentesque hendrerit est id quam facilisis auctor a ut ante. Etiam metus arcu, sagittis vitae massa ac, faucibus tempus dolor. Sed et tempus ex. Aliquam interdum erat vel convallis tristique. Phasellus lectus eros, interdum ac sollicitudin vestibulum, scelerisque vitae ligula. Cras aliquam est id velit laoreet, et mattis massa ultrices. Ut aliquam mi nunc, et tempor neque malesuada in.', '', '', '', 0, 'mnf-comapny-jobs-in-new york-web-design-frontend-developer-12', '101.50.114.8', NULL, NULL, 'html, css, photoshop, illustrator, js', 0, NULL, NULL, NULL, NULL, NULL),
(13, 12, 'Account Officer', 12, 18, '41000-50000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'MS', 'Fresh', 'New York', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'qwe-company-jobs-in-new york-account-officer-13', '115.186.165.234', NULL, NULL, 'accounting, marketing, ms office', 0, NULL, NULL, NULL, NULL, NULL),
(14, 13, 'Call Center Operator', 13, 10, '51000-60000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'Certification', '4', 'Los Angeles', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'asd-company-jobs-in-los angeles-call-center-operator-14', '115.186.165.234', NULL, NULL, 'marketting, ms office, mysql', 0, NULL, NULL, NULL, NULL, NULL),
(15, 14, 'Hr Specilest', 14, 18, '51000-60000', '2016-03-12', 'blocked', 'no', 'United States', '2016-07-12', '', 'MBA', '3', 'Las Vegas', 'Full Time', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a velit sed risus pulvinar faucibus. Nulla facilisi. Nullam vehicula nec ligula eu vulputate. Nunc id ultrices mi, ac tristique lectus. Suspendisse porta ultrices ultricies. Sed quis nisi vel magna maximus aliquam a vel nisl. Cras non rutrum diam. Nulla sed ipsum a felis posuere pharetra ut sit amet augue. Sed id nisl sodales, vulputate mi eu, viverra neque. Fusce fermentum, est ut accumsan accumsan, risus ante varius diam, non venenatis eros ligula fermentum leo. Etiam consectetur imperdiet volutpat. Donec ut pharetra nisi, eget pellentesque tortor. Integer eleifend dolor eu ex lobortis, ac gravida augue tristique. Proin placerat consectetur tincidunt. Nullam sollicitudin, neque eget iaculis ultricies, est justo pulvinar turpis, vulputate convallis leo orci at sapien.<br />\n<br />\nQuisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '', '', '', 0, 'xcv-company-jobs-in-las vegas-hr-specilest-15', '115.186.165.234', NULL, NULL, 'ms office, html, css, mysql', 0, NULL, NULL, NULL, NULL, NULL),
(114, 209, 'Developer', 209, 22, 'Depends', '2018-01-25', 'pending', 'yes', 'Sweden', '2018-01-31', '', 'MS', 'Fresh', 'Stockholm', 'Full Time', 1, 'This&nbsp;is a&nbsp;job&nbsp;post&nbsp;test by&nbsp;bixma.', 'Ramzi', 'bixmatech@gmail.com', '0046700775775', 0, 'bixma-jobs-in-stockholm-developer-114', '90.224.199.144', NULL, NULL, 'word', 0, 'Who are we?', 'Bixma', 'Bima', 'Bixa', '        <div style=\'width: 750px;max-width: 750px; margin: auto;\' id=\'canvas\'>\r\n        <div class=\'companyinfoWrp\'>\r\n\r\n        <h1 class=\'jobname\'>Developer</h1>\r\n        <div class=\'jobthumb\'><img src=\'http://vps47202.lws-hosting.com/public/uploads/employer/JOBPORTAL-1516898144.png\' /></div>\r\n        <div class=\'jobloc\'><h3>Bixma</h3>\r\n        </div>\r\n        <div class=\'clear\'></div>\r\n        </div>\r\n        </div>\r\n        '),
(115, 210, 'Laravel Developer', 210, 22, '350000-450000', '2018-01-25', 'active', 'yes', 'Canada', '2018-05-25', '', 'CA', 'Less than 1', 'N.A', 'Full Time', 1, 'We need a Laravel developer.', '', '', '', 0, 'ego-dev-jobs-in-n.a-laravel-developer-115', '105.71.136.97', NULL, NULL, 'php, laravel', 0, '', '', '', '', NULL),
(116, 210, 'Lärare', 210, 35, 'Trainee Stipend', '2018-01-25', 'active', 'yes', 'Sweden', '2018-05-25', '', 'MBA', 'Fresh', 'N.A', 'Full Time', 1, 'L&auml;rare.', 'Timéo Skarander', 'info@travos.se', '+46723189657', 0, 'travos-ab-jobs-in-n.a-lrare-116', '158.174.4.45', NULL, NULL, 'hhhhh, lärare', 0, '', '', '', '', NULL),
(117, 216, 'Advokat', 216, 42, '26000-30000', '2018-01-26', 'active', 'yes', 'Sweden', '2018-05-26', '', 'BA', 'Fresh', 'Malmö', 'Part Time', 10, '&Auml;r du nyexaminerad advokat och &auml;r nyfiken p&aring; ett arbete i allm&auml;n f&ouml;rvaltningsdomstol innan du forts&auml;tter din yrkeskarri&auml;r? Arbetet p&aring;minner i stora delar om arbetet som f&ouml;redragande jurist, vilket &auml;r ett arbete som i regel endast erfarna jurister kommer i fr&aring;ga f&ouml;r. Arbetet som f&ouml;redragande jurist &auml;r ett kvalificerat juristarbete som best&aring;r i att bereda m&aring;l, g&ouml;ra r&auml;ttsutredningar, f&ouml;redra m&aring;l f&ouml;r avg&ouml;rande, vara protokollf&ouml;rare vid muntliga f&ouml;rhandlingar samt att utarbeta f&ouml;rslag till domar eller beslut. Som jurist inom migrationsr&auml;tt ges du m&ouml;jlighet att arbeta under handledning av v&aring;ra mentorer.<br />\r\nKvalifikationer<br />\r\nF&ouml;r att komma i fr&aring;ga f&ouml;r tj&auml;nsten ska du nyligen ha tagit din juristexamen och bifoga ditt examensbevis, max 1 sida, i din ans&ouml;kan.<br />\r\nVi ser g&auml;rna att du har utbildning och/eller erfarenhet inom migrationsr&auml;tt.<br />\r\nDu &auml;r en noggrann person som har f&ouml;rm&aring;ga att strukturera och planera ditt arbete. Du kan organisera och prioritera olika arbetsuppgifter. Du uttrycker dig v&auml;l i b&aring;de tal och skrift. Du kan arbeta sj&auml;lvst&auml;ndigt men har ocks&aring; l&auml;tt f&ouml;r att samarbeta och arbeta i grupp.<br />\r\nVi f&auml;ster stor vikt vid personliga egenskaper och d&auml;rf&ouml;r kommer testning att vara en del av rekryteringsprocessen.', '', '', '', 0, 'malm-tingsrtt-jobs-in-malmö-advokat-117', '83.183.12.57', NULL, NULL, 'advokat', 0, '', 'advokat', '', '', NULL),
(118, 213, 'Advokat', 213, 42, '31000-35000', '2018-01-27', 'active', 'no', 'Sweden', '2018-02-28', '', 'BA', 'Fresh', 'Jönköping', 'Part Time', 10, 'advokat, word', '', '', '', 0, 'jnkpings-tingsrtt-jobs-in-jönköping-advokat-118', '2.65.17.62', NULL, NULL, 'advokat, word', 0, '', 'advokat', '', '', NULL),
(119, 215, 'Administratör  - Eskilstuna', 215, 42, '21000-25000', '2018-01-28', 'active', 'no', 'Sweden', '2018-05-31', '', 'MBA', '2', 'Eskilstuna', 'Part Time', 2, 'Hej! Eskilstuna tingsr&auml;tt har nu en ledig position som administrat&ouml;r p&aring; deltid.&nbsp;', '', '', '', 0, 'eskilstuna-tingsrtt-jobs-in-eskilstuna-administratr-eskilstuna-119', '83.183.12.57', NULL, NULL, 'excel , administratör', 0, 'har du en universitets examen? ', '', '', '', NULL),
(120, 213, 'Jurist', 213, 42, '26000-30000', '2018-01-28', 'active', 'no', 'Sweden', '2018-03-29', '', 'BA', '2', 'Jönköping', 'Full Time', 1, 'Dokumenterade erafrenheter.<br />\r\nIntyg kr&auml;vs.', '', '', '', 0, 'jnkpings-tingsrtt-jobs-in-jönköping-jurist-120', '83.183.12.57', NULL, NULL, 'jurist, word, engelska', 0, '', 'Jurist?', 'Word', '', NULL),
(121, 211, '2 Kvalificerade åklagare Sökes', 211, 42, '26000-30000', '2018-01-28', 'active', 'yes', 'Sweden', '2018-06-14', '', 'PhD', '3', 'Sollentuna', 'Full Time', 2, 'Vi s&ouml;ker 2 &aring;klagare till Attunda tingsr&auml;tt', '', '', '', 0, 'attunda-tingsrtt-jobs-in-sollentuna-2-kvalificerade-klagare-skes-121', '83.183.12.57', NULL, NULL, 'jurist, entreprenör', 0, 'Är du behörig åklagare', 'Ja', 'Nej', 'Blivande', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_prohibited_keywords`
--

DROP TABLE IF EXISTS `tbl_prohibited_keywords`;
CREATE TABLE `tbl_prohibited_keywords` (
  `ID` int(11) NOT NULL,
  `keyword` varchar(150) NOT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_prohibited_keywords`
--

TRUNCATE TABLE `tbl_prohibited_keywords`;
--
-- Contenu de la table `tbl_prohibited_keywords`
--

INSERT INTO `tbl_prohibited_keywords` (`ID`, `keyword`) VALUES
(8, 'idiot'),
(9, 'fuck'),
(10, 'bitch');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_qualifications`
--

DROP TABLE IF EXISTS `tbl_qualifications`;
CREATE TABLE `tbl_qualifications` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_qualifications`
--

TRUNCATE TABLE `tbl_qualifications`;
--
-- Contenu de la table `tbl_qualifications`
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
-- Structure de la table `tbl_salaries`
--

DROP TABLE IF EXISTS `tbl_salaries`;
CREATE TABLE `tbl_salaries` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_salaries`
--

TRUNCATE TABLE `tbl_salaries`;
--
-- Contenu de la table `tbl_salaries`
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
-- Structure de la table `tbl_scam`
--

DROP TABLE IF EXISTS `tbl_scam`;
CREATE TABLE `tbl_scam` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `reason` text,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(60) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_scam`
--

TRUNCATE TABLE `tbl_scam`;
--
-- Contenu de la table `tbl_scam`
--

INSERT INTO `tbl_scam` (`ID`, `user_ID`, `job_ID`, `reason`, `dated`, `ip_address`) VALUES
(1, 210, 13, 'gfhgjhgk jbbv', '2016-12-26 04:07:46', '112.133.246.101'),
(2, 390, 8, 'rrrrrrr', '2017-04-19 10:47:13', '47.11.211.152');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_academic`
--

DROP TABLE IF EXISTS `tbl_seeker_academic`;
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
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_academic`
--

TRUNCATE TABLE `tbl_seeker_academic`;
--
-- Contenu de la table `tbl_seeker_academic`
--

INSERT INTO `tbl_seeker_academic` (`ID`, `seeker_ID`, `degree_level`, `degree_title`, `major`, `institude`, `country`, `city`, `completion_year`, `dated`, `flag`, `old_id`) VALUES
(1, 10, NULL, 'BA', 'test', 'teste e ere', 'United States of America', 'New york', 2012, '2016-03-12 13:05:55', NULL, NULL),
(37, 423, NULL, 'BS', 'software', 'IT institute', 'Paraguay', 'kep', 2022, '2018-01-25 11:36:30', NULL, NULL),
(38, 10, NULL, 'BE', 'NOTHING', 'Like', 'Pakistan', 'Job', 2023, '2018-01-27 03:26:58', NULL, NULL),
(39, 430, NULL, 'PhD', 'Rekrytering', 'handelshögskolan sverige', 'Sweden', 'stockholm', 2012, '2018-01-28 04:48:49', NULL, NULL),
(40, 428, NULL, 'PhD', 'Jurist', 'Luleå Tekniska Universitet', 'Sweden', 'LULEÅ', 2012, '2018-01-28 04:50:10', NULL, NULL),
(41, 429, NULL, 'BA', 'Juristprogrammet', 'Uppsala universitet', 'Sweden', 'Uppsala', 2010, '2018-01-28 04:52:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_additional_info`
--

DROP TABLE IF EXISTS `tbl_seeker_additional_info`;
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
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_additional_info`
--

TRUNCATE TABLE `tbl_seeker_additional_info`;
--
-- Contenu de la table `tbl_seeker_additional_info`
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
(363, 431, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_applied_for_job`
--

DROP TABLE IF EXISTS `tbl_seeker_applied_for_job`;
CREATE TABLE `tbl_seeker_applied_for_job` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) NOT NULL,
  `job_ID` int(11) NOT NULL,
  `cover_letter` text,
  `expected_salary` varchar(20) DEFAULT NULL,
  `dated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip_address` varchar(40) DEFAULT NULL,
  `employer_ID` int(11) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `withdraw` tinyint(1) DEFAULT '0',
  `file_name` varchar(155) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_applied_for_job`
--

TRUNCATE TABLE `tbl_seeker_applied_for_job`;
--
-- Contenu de la table `tbl_seeker_applied_for_job`
--

INSERT INTO `tbl_seeker_applied_for_job` (`ID`, `seeker_ID`, `job_ID`, `cover_letter`, `expected_salary`, `dated`, `ip_address`, `employer_ID`, `flag`, `old_id`, `answer`, `withdraw`, `file_name`) VALUES
(1, 9, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa nisl, porttitor id urna sagittis, mollis tristique diam. Donec augue nulla, tempus id egestas finibus, sodales a ligula. Suspendisse lacinia malesuada sapien nec pretium. Curabitur sed augue sed neque vulputate congue at pellentesque ante. Aliquam facilisis cursus eros, in laoreet risus luctus non. Aliquam tincidunt purus in urna molestie, eget aliquet lectus sollicitudin. Proin pretium tellus maximus dolor dapibus aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed bibendum nulla. Nulla ac magna placerat, tristique nisl a, consectetur lectus. Pellentesque quis enim semper, placerat augue vel, faucibus urna. Nullam ut odio volutpat, scelerisque mi ac, ornare libero.', 'Trainee Stipend', '2016-03-12 01:53:57', NULL, 7, NULL, NULL, NULL, 0, NULL),
(2, 10, 12, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', '21000-25000', '2016-03-12 13:06:43', NULL, 11, NULL, NULL, NULL, 0, NULL),
(3, 10, 9, 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl, elementum eu sapien ut, convallis interdum felis. In turpis odio, fermentum non pulvinar gravida, posuere quis magna. Ut mollis eget neque at euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer faucibus orci a pulvinar malesuada. Aenean at felis vitae lorem venenatis consequat. Nam non nunc euismod, consequat ligula non, tristique odio. Ut leo sapien, aliquet sed ultricies et, scelerisque quis nulla. Aenean non sapien maximus, convallis eros vitae, iaculis massa. In fringilla hendrerit nisi, eu pellentesque massa faucibus molestie. Etiam laoreet eros quis faucibus rutrum. Quisque eleifend purus justo, eget tempus quam interdum non.', 'Trainee Stipend', '2016-03-12 13:07:08', NULL, 8, NULL, NULL, NULL, 0, NULL),
(4, 11, 9, 'Test', '5000-10000', '2016-03-28 14:14:16', NULL, 8, NULL, NULL, NULL, 0, NULL),
(5, 11, 15, 'Account Officer', 'Trainee Stipend', '2016-03-28 14:14:39', NULL, 14, NULL, NULL, NULL, 0, NULL),
(6, 11, 7, 'Account Officer', 'Trainee Stipend', '2016-03-28 14:15:03', NULL, 6, NULL, NULL, NULL, 0, NULL),
(7, 12, 15, 'bcchchv', '5000-10000', '2016-03-28 14:47:58', NULL, 14, NULL, NULL, NULL, 0, NULL),
(249, 423, 114, 'kjhgv', 'Trainee Stipend', '2018-01-26 13:58:01', NULL, 209, NULL, NULL, 'Bixma', 1, '6584671253112463d28fa41c01302af4.docx'),
(234, 424, 116, 'lnvlnvlkvnln', '36000-40000', '2018-01-25 15:57:52', NULL, 210, NULL, NULL, NULL, 0, ''),
(225, 423, 15, 'bh', 'Trainee Stipend', '2018-01-25 11:28:08', NULL, 14, NULL, NULL, NULL, 0, 'f65391cb5f83d4f1bc335d9ffeaaf74d.docx'),
(233, 424, 115, 'Hi', '5000-10000', '2018-01-25 14:20:43', NULL, 210, NULL, NULL, NULL, 0, ''),
(237, 10, 2, 'Hi', 'Trainee Stipend', '2018-01-26 03:34:54', NULL, 1, NULL, NULL, NULL, 0, ''),
(238, 10, 116, 'asa', 'Trainee Stipend', '2018-01-26 04:08:23', NULL, 210, NULL, NULL, NULL, 1, ''),
(239, 423, 116, 'This is the salary I want. take it or leave it', '281000-350000', '2018-01-26 09:37:12', NULL, 210, NULL, NULL, NULL, 0, '8fa7bd03654fa8191efa231c5a1045f8.rtf'),
(240, 423, 115, 'mfghjl', 'Trainee Stipend', '2018-01-26 09:44:15', NULL, 210, NULL, NULL, NULL, 0, '5c1c40d526286275cc1793f6df466a91.docx'),
(242, 427, 117, 'bbbbb', '26000-30000', '2018-01-26 13:02:02', NULL, 216, NULL, NULL, NULL, 0, '___'),
(243, 426, 117, 'jbh', 'Trainee Stipend', '2018-01-26 13:11:21', NULL, 216, NULL, NULL, NULL, 0, '___'),
(244, 426, 114, 'm,bn', 'Trainee Stipend', '2018-01-26 13:12:41', NULL, 209, NULL, NULL, 'Bixma', 0, '___'),
(248, 10, 114, 's', 'Trainee Stipend', '2018-01-26 13:44:09', NULL, 209, NULL, NULL, 'Bixma', 0, '91d0a04552dc8baf00138d36a3d61bbd.jpg$*_,_*$3a04eac4fc243086516f3a171261d63a.png$*_,_*$cb31408e2f0dcf1ca47ebd53ccbf6632.jpg'),
(246, 427, 116, 'ihougf', 'Trainee Stipend', '2018-01-26 13:30:48', NULL, 210, NULL, NULL, NULL, 0, 'edd6eece2047d48a5b6cf37ad7aed82d.rtf'),
(247, 427, 114, 'b', 'Trainee Stipend', '2018-01-26 13:35:08', NULL, 209, NULL, NULL, 'Bixma', 0, 'e631542adf3714fad3b41bf86435872b.rtf'),
(250, 423, 117, 'l;knb', 'Trainee Stipend', '2018-01-26 14:03:39', NULL, 216, NULL, NULL, NULL, 0, '3d8d7b0439f6689f2659a066a373f5a4.rtf$*_,_*$ff078a7693b6c9b4ff81735ba23db58b.png$*_,_*$f032199c8deaa8de42df235258efa02a.docx'),
(251, 423, 118, 'Gjfx', 'Trainee Stipend', '2018-01-27 07:36:22', NULL, 213, NULL, NULL, NULL, 0, ''),
(253, 424, 118, 'ss', 'Trainee Stipend', '2018-01-27 08:46:30', NULL, 213, NULL, NULL, NULL, 1, '41c5d4628bfd955d31c7501d1406ea56.docx$*_,_*$e62b124f110dd7d5e971f28f3de9596c.docx$*_,_*$996ce50a4ac39f0c10d6cb0f92f592af.docx$*_,_*$ea8cc30028fe65c7a734120'),
(254, 428, 120, 'Hej!\r\n\r\nJag söker jobb omgående', '41000-50000', '2018-01-28 04:59:14', NULL, 213, NULL, NULL, NULL, 0, 'b61674aa34ee3febfbb00fdaabb7ec18.docx'),
(255, 430, 121, 'Hej jag vill VERKLIGEN ha det här arbetet.', '81000-100000', '2018-01-28 04:59:16', NULL, 211, NULL, NULL, 'Blivande', 0, ''),
(256, 429, 121, 'Hej,\n\nJag är mycket intresserad om tjänsten....', '21000-25000', '2018-01-28 04:59:19', NULL, 211, NULL, NULL, 'Ja', 0, ''),
(257, 429, 120, 'Mycket intressant!', '26000-30000', '2018-01-28 05:00:14', NULL, 213, NULL, NULL, NULL, 0, ''),
(258, 430, 119, 'hej jag vill verkligen ha det här arbetet', '51000-60000', '2018-01-28 05:01:05', NULL, 215, NULL, NULL, '', 0, ''),
(259, 428, 121, 'Jobb behövs omgående', '16000-20000', '2018-01-28 05:01:59', NULL, 211, NULL, NULL, 'Blivande', 0, 'd6e0002f71ccde4d741d5dfe2ae98e55.docx'),
(260, 429, 119, 'Hello', '26000-30000', '2018-01-28 05:02:05', NULL, 215, NULL, NULL, '', 0, ''),
(261, 430, 120, 'abc', '36000-40000', '2018-01-28 05:04:13', NULL, 213, NULL, NULL, NULL, 0, ''),
(262, 423, 121, 'mbvh', 'Trainee Stipend', '2018-01-28 06:06:59', NULL, 211, NULL, NULL, 'Ja', 0, '0a2173045af8221c747412edc63ccec6.txt$*_,_*$386f0b7cf346fdf05ee4e0ca396d0222.rtf$*_,_*$d47645053e47f25381724dc1974b8317.rtf');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_experience`
--

DROP TABLE IF EXISTS `tbl_seeker_experience`;
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
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_experience`
--

TRUNCATE TABLE `tbl_seeker_experience`;
--
-- Contenu de la table `tbl_seeker_experience`
--

INSERT INTO `tbl_seeker_experience` (`ID`, `seeker_ID`, `job_title`, `company_name`, `start_date`, `end_date`, `city`, `country`, `responsibilities`, `dated`, `flag`, `old_id`) VALUES
(1, 9, 'test', 'testete', '2012-02-16', NULL, 'New york', 'United States of America', NULL, '2016-03-12 02:10:41', NULL, NULL),
(60, 423, 'Developer', 'teslok', '2019-01-02', '2018-01-11', 'gooda', 'St Vincent & Grenadines', NULL, '2018-01-25 11:35:42', NULL, NULL),
(61, 10, 'Developer', 'SURNATUREL', '2018-01-25', NULL, 'Nice', 'Macau', NULL, '2018-01-27 03:26:35', NULL, NULL),
(62, 430, 'Chef', 'Hej Aktiebolag', '2018-01-15', '2018-01-30', 'Stockholm', 'Sweden', NULL, '2018-01-28 04:48:00', NULL, NULL),
(63, 428, 'Pizzabud', 'Dominos', '2016-11-15', '2018-01-03', 'LULEÅ', 'Sweden', NULL, '2018-01-28 04:49:19', NULL, NULL),
(64, 429, 'Åklagare', 'Eskilstuna tingsrätt', '2014-01-02', '2017-01-11', 'Eskilstuna', 'Sweden', NULL, '2018-01-28 04:49:19', NULL, NULL),
(65, 429, 'Adminsitratör', 'Göteborgs tingsrätt', '2017-02-02', '2017-03-08', 'Göteborg', 'Afganistan', NULL, '2018-01-28 04:51:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_resumes`
--

DROP TABLE IF EXISTS `tbl_seeker_resumes`;
CREATE TABLE `tbl_seeker_resumes` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `is_uploaded_resume` enum('no','yes') DEFAULT 'no',
  `file_name` varchar(155) DEFAULT NULL,
  `resume_name` varchar(40) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `is_default_resume` enum('no','yes') DEFAULT 'no'
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_resumes`
--

TRUNCATE TABLE `tbl_seeker_resumes`;
--
-- Contenu de la table `tbl_seeker_resumes`
--

INSERT INTO `tbl_seeker_resumes` (`ID`, `seeker_ID`, `is_uploaded_resume`, `file_name`, `resume_name`, `dated`, `is_default_resume`) VALUES
(1, 8, 'yes', 'test-test-8-BiXma.docx', NULL, '2016-03-12 01:44:43', 'no'),
(2, 10, 'no', 'michel-jen-9-BiXma.docx', NULL, '2016-03-12 01:51:56', 'no'),
(4, 10, 'yes', 'jhony-man-BiXma.docx', 'Ayoub', '2016-03-12 13:07:50', 'no'),
(5, 11, 'yes', 'kganxx-11-BiXma.docx', NULL, '2016-03-28 14:11:09', 'yes'),
(6, 12, 'yes', 'kacykos-12-BiXma.jpg', NULL, '2016-03-28 14:46:29', 'no'),
(7, 13, 'yes', 'ajay-13-BiXma.txt', NULL, '2016-03-28 17:40:38', 'no'),
(8, 14, 'yes', 'peter-sturm-14-BiXma.pdf', NULL, '2016-03-28 18:18:22', 'no'),
(361, 411, 'yes', 'gfgfgfhh-411-BiXma.docx', NULL, '2018-01-25 09:49:27', 'no'),
(362, 422, 'yes', 'a-422-BiXma.pdf', NULL, '2018-01-25 10:07:35', 'no'),
(365, 424, 'yes', 'ayoub-ezzini-424-BiXma.pdf', NULL, '2018-01-25 14:08:33', 'no'),
(366, 425, 'yes', 'kali-linux-425-BiXma.pdf', NULL, '2018-01-26 06:02:03', 'no'),
(367, 426, 'yes', 'ramtan-426-BiXma.rtf', NULL, '2018-01-26 12:31:56', 'no'),
(368, 427, 'yes', 'tim-s-427-BiXma.doc', NULL, '2018-01-26 13:01:10', 'no'),
(369, 424, 'yes', 'ayoub-ezzini-BiXma.doc', NULL, '2018-01-27 08:57:26', 'yes'),
(370, 424, 'yes', 'ayoub-ezzini-BiXma.pdf', NULL, '2018-01-27 08:57:58', 'no'),
(380, 423, 'yes', 'ram-BiXma-4231517141404.rtf', NULL, '2018-01-28 06:10:04', 'no'),
(376, 429, 'yes', 'johan-gustafsson-BiXma-4291517137630.docx', NULL, '2018-01-28 05:07:10', 'yes'),
(374, 430, 'yes', 'william-schwarz-BiXma-4301517136904.png', NULL, '2018-01-28 04:55:04', 'yes'),
(375, 428, 'yes', 'fredrik-hrn-BiXma-4281517136909.docx', NULL, '2018-01-28 04:55:09', 'yes'),
(377, 428, 'yes', 'fredrik-hrn-BiXma-4281517138714.docx', NULL, '2018-01-28 05:25:14', 'no'),
(378, 428, 'yes', 'fredrik-hrn-BiXma-4281517138743.docx', NULL, '2018-01-28 05:25:43', 'no'),
(379, 423, 'yes', 'ram-BiXma-4231517141311.rtf', NULL, '2018-01-28 06:08:31', 'yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_skills`
--

DROP TABLE IF EXISTS `tbl_seeker_skills`;
CREATE TABLE `tbl_seeker_skills` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `skill_name` varchar(155) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_seeker_skills`
--

TRUNCATE TABLE `tbl_seeker_skills`;
--
-- Contenu de la table `tbl_seeker_skills`
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
(986, 424, 'laravel'),
(987, 424, 'codeigniter'),
(988, 424, 'lärare'),
(989, 425, 'a'),
(990, 425, 'b'),
(991, 425, 'c'),
(992, 426, 'word'),
(993, 426, 'excel'),
(1004, 426, 'php'),
(996, 425, 'advokat'),
(997, 424, 'advokat'),
(998, 423, 'advokat'),
(999, 411, 'advokat'),
(1000, 11, 'advokat'),
(1001, 427, 'advokat'),
(1002, 427, 'word'),
(1003, 427, 'excel'),
(1005, 427, 'developer'),
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
(1021, 431, 'illustrator');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_sessions`
--

DROP TABLE IF EXISTS `tbl_sessions`;
CREATE TABLE `tbl_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_sessions`
--
-- --------------------------------------------------------

--
-- Structure de la table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE `tbl_settings` (
  `ID` int(11) NOT NULL,
  `emails_per_hour` int(5) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_settings`
--

TRUNCATE TABLE `tbl_settings`;
--
-- Contenu de la table `tbl_settings`
--

INSERT INTO `tbl_settings` (`ID`, `emails_per_hour`) VALUES
(1, 300);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_skills`
--

DROP TABLE IF EXISTS `tbl_skills`;
CREATE TABLE `tbl_skills` (
  `ID` int(11) NOT NULL,
  `skill_name` varchar(40) DEFAULT NULL,
  `industry_ID` int(11) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_skills`
--

TRUNCATE TABLE `tbl_skills`;
--
-- Contenu de la table `tbl_skills`
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
(34, 'lärare', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_stories`
--

DROP TABLE IF EXISTS `tbl_stories`;
CREATE TABLE `tbl_stories` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) NOT NULL,
  `is_featured` enum('yes','no') DEFAULT 'no',
  `sts` enum('active','inactive') DEFAULT 'inactive',
  `title` varchar(250) DEFAULT NULL,
  `story` text,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL
) ;

--
-- Vider la table avant d'insérer `tbl_stories`
--

TRUNCATE TABLE `tbl_stories`;
--
-- Index pour les tables exportées
--

--
-- Index pour la table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_job_seeker` (`id_job_seeker`),
  ADD KEY `id_employer` (`id_employer`);

--
-- Index pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_ad_codes`
--
ALTER TABLE `tbl_ad_codes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_cms`
--
ALTER TABLE `tbl_cms`
  ADD PRIMARY KEY (`pageID`);

--
-- Index pour la table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  ADD PRIMARY KEY (`id_conversation`),
  ADD KEY `id_employer` (`id_employer`),
  ADD KEY `id_job_seeker` (`id_job_seeker`);

--
-- Index pour la table `tbl_conv_message`
--
ALTER TABLE `tbl_conv_message`
  ADD PRIMARY KEY (`id_conv_message`),
  ADD KEY `id_sender` (`id_sender`),
  ADD KEY `id_conversation` (`id_conversation`);

--
-- Index pour la table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_email_content`
--
ALTER TABLE `tbl_email_content`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_employers`
--
ALTER TABLE `tbl_employers`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_favourite_candidates`
--
ALTER TABLE `tbl_favourite_candidates`
  ADD PRIMARY KEY (`employer_id`);

--
-- Index pour la table `tbl_favourite_companies`
--
ALTER TABLE `tbl_favourite_companies`
  ADD PRIMARY KEY (`seekerid`);

--
-- Index pour la table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_institute`
--
ALTER TABLE `tbl_institute`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_alert`
--
ALTER TABLE `tbl_job_alert`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_alert_queue`
--
ALTER TABLE `tbl_job_alert_queue`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_functional_areas`
--
ALTER TABLE `tbl_job_functional_areas`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_industries`
--
ALTER TABLE `tbl_job_industries`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_seekers`
--
ALTER TABLE `tbl_job_seekers`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_job_titles`
--
ALTER TABLE `tbl_job_titles`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_post_jobs`
--
ALTER TABLE `tbl_post_jobs`
  ADD PRIMARY KEY (`ID`);
-- ALTER TABLE `tbl_post_jobs` ADD FULLTEXT KEY `job_search` (`job_title`,`job_description`);

--
-- Index pour la table `tbl_prohibited_keywords`
--
ALTER TABLE `tbl_prohibited_keywords`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_qualifications`
--
ALTER TABLE `tbl_qualifications`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_scam`
--
ALTER TABLE `tbl_scam`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_seeker_academic`
--
ALTER TABLE `tbl_seeker_academic`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_seeker_additional_info`
--
ALTER TABLE `tbl_seeker_additional_info`
  ADD PRIMARY KEY (`ID`);
-- ALTER TABLE `tbl_seeker_additional_info` ADD FULLTEXT KEY `resume_search` (`summary`,`keywords`);

--
-- Index pour la table `tbl_seeker_applied_for_job`
--
ALTER TABLE `tbl_seeker_applied_for_job`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_seeker_experience`
--
ALTER TABLE `tbl_seeker_experience`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_seeker_resumes`
--
ALTER TABLE `tbl_seeker_resumes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_seeker_skills`
--
ALTER TABLE `tbl_seeker_skills`
  ADD PRIMARY KEY (`ID`);
-- ALTER TABLE `tbl_seeker_skills` ADD FULLTEXT KEY `js_skill_search` (`skill_name`);

--
-- Index pour la table `tbl_sessions`
--
ALTER TABLE `tbl_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Index pour la table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbl_stories`
--
ALTER TABLE `tbl_stories`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_ad_codes`
--
ALTER TABLE `tbl_ad_codes`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_cms`
--
ALTER TABLE `tbl_cms`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  MODIFY `id_conversation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_conv_message`
--
ALTER TABLE `tbl_conv_message`
  MODIFY `id_conv_message` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_email_content`
--
ALTER TABLE `tbl_email_content`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_employers`
--
ALTER TABLE `tbl_employers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_favourite_candidates`
--
ALTER TABLE `tbl_favourite_candidates`
  MODIFY `employer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_favourite_companies`
--
ALTER TABLE `tbl_favourite_companies`
  MODIFY `seekerid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_institute`
--
ALTER TABLE `tbl_institute`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_alert`
--
ALTER TABLE `tbl_job_alert`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_alert_queue`
--
ALTER TABLE `tbl_job_alert_queue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_functional_areas`
--
ALTER TABLE `tbl_job_functional_areas`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_industries`
--
ALTER TABLE `tbl_job_industries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_seekers`
--
ALTER TABLE `tbl_job_seekers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_job_titles`
--
ALTER TABLE `tbl_job_titles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_post_jobs`
--
ALTER TABLE `tbl_post_jobs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_prohibited_keywords`
--
ALTER TABLE `tbl_prohibited_keywords`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_qualifications`
--
ALTER TABLE `tbl_qualifications`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_scam`
--
ALTER TABLE `tbl_scam`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_academic`
--
ALTER TABLE `tbl_seeker_academic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_additional_info`
--
ALTER TABLE `tbl_seeker_additional_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_applied_for_job`
--
ALTER TABLE `tbl_seeker_applied_for_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_experience`
--
ALTER TABLE `tbl_seeker_experience`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_resumes`
--
ALTER TABLE `tbl_seeker_resumes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_skills`
--
ALTER TABLE `tbl_seeker_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_stories`
--
ALTER TABLE `tbl_stories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
