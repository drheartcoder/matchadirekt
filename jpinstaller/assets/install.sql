-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 27 Janvier 2018 à 14:28
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

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `count_active_opened_jobs` ()  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.sts='active' AND CURRENT_DATE < pj.last_date;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_active_opened_jobs_by_company_id` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(ID) as total
	FROM `tbl_post_jobs` AS pj
	WHERE pj.company_ID=comp_id AND pj.sts='active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_active_records_by_city_front_end` (IN `city` VARCHAR(40))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.city=city AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_active_records_by_industry_front_end` (IN `industry_id` INT(11))  BEGIN
	SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.industry_ID=industry_id AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11))  BEGIN
		SELECT COUNT(pj.ID) AS total
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_applied_jobs_by_employer_id` (IN `employer_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_post_jobs.employer_ID=employer_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT COUNT(tbl_seeker_applied_for_job.ID) AS total
	FROM `tbl_seeker_applied_for_job`
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255))  BEGIN
	SELECT COUNT(pj.ID) as total
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_ft_search_job` (IN `param` VARCHAR(255), `param2` VARCHAR(255))  BEGIN
	SELECT COUNT(pc.ID) as total
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = 'active' AND pc.sts = 'active'
AND (pj.job_title like CONCAT("%",param,"%") OR pj.job_description like CONCAT("%",param,"%") OR pj.required_skills like CONCAT("%",param,"%"))
AND pj.city like CONCAT("%",param2,"%");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_ft_search_resume` (IN `param` VARCHAR(255))  BEGIN
	SELECT COUNT(DISTINCT ss.ID) as total
	FROM `tbl_job_seekers` js 
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' 
AND ss.skill_name like CONCAT('%',param,'%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_search_posted_jobs` (IN `where_condition` VARCHAR(255))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_job_search_filter_3` (IN `param_city` VARCHAR(255), `param_company_slug` VARCHAR(255), `param_title` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, MATCH(pj.job_title, pj.job_description) AGAINST( param_title ) AS score
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE (pj.job_title like CONCAT("%",param_title,"%") OR pj.job_description like CONCAT("%",param_title,"%") OR pj.required_skills like CONCAT("%",param_title,"%")) 
AND pc.company_slug = param_company_slug AND pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'

ORDER BY score DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_job` (IN `param` VARCHAR(255), `param2` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN

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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_jobs_group_by_city` (IN `param` VARCHAR(255))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_jobs_group_by_company` (IN `param` VARCHAR(255))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_jobs_group_by_salary_range` (IN `param` VARCHAR(255))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_jobs_group_by_title` (IN `param` VARCHAR(255))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ft_search_resume` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
  SELECT js.ID, js.first_name, js.gender, js.dob, js.city, js.photo
	FROM tbl_job_seekers AS js
	INNER JOIN tbl_seeker_skills AS ss ON js.ID=ss.seeker_ID
	WHERE js.sts = 'active' AND ss.skill_name like CONCAT("%",param,"%")
  GROUP BY ss.seeker_ID
	ORDER BY js.ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_active_deactive_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts IN ('active', 'inactive', 'pending') AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_active_featured_job` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes' AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_active_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_active_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, emp.first_name, emp.email AS employer_email, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,emp.city as emp_city, emp.country as emp_country	
FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON pc.ID=emp.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND pc.sts = 'active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_active_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_active_top_employers` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pc.ID AS CID, pc.company_name, pc.company_logo, pc.company_slug
	FROM `tbl_employers` emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE emp.sts = 'active' AND emp.top_employer = 'yes'
	ORDER BY emp.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_opened_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, ji.industry_name 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	INNER JOIN tbl_job_industries AS ji ON pj.industry_ID=ji.ID
	WHERE pj.sts = 'active' AND pc.sts='active'
	ORDER BY pj.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_posted_jobs` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug, pj.ip_address 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_posted_jobs_by_company_id_frontend` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` AS pj
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.company_ID=comp_id AND pj.sts='active' AND pc.sts = 'active'
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_posted_jobs_by_status` (IN `job_status` VARCHAR(10), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
	WHERE pj.sts = job_status
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_applied_jobs_by_employer_id` (IN `employer_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.dated AS applied_date,tbl_seeker_applied_for_job.seeker_ID,tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_job_seekers.ID AS job_seeker_ID, tbl_post_jobs.job_slug, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.slug
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
	WHERE tbl_post_jobs.employer_ID=employer_id 
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_applied_jobs_by_jobseeker_id` (IN `jobseeker_id` INT(11), IN `from_limit` INT(5), IN `to_limit` INT(5))  BEGIN
	SELECT tbl_seeker_applied_for_job.ID as applied_id, tbl_seeker_applied_for_job.dated AS applied_date, tbl_seeker_applied_for_job.withdraw, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_companies.company_name, tbl_companies.company_slug, tbl_companies.company_logo 
	FROM `tbl_seeker_applied_for_job`
	INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
	INNER JOIN tbl_employers ON tbl_employers.ID=tbl_post_jobs.employer_ID
	INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_ID
	WHERE tbl_seeker_applied_for_job.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_applied_for_job.ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_applied_jobs_by_seeker_id` (IN `applicant_id` INT(11), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT aj.*, tbl_post_jobs.ID AS posted_job_id, tbl_seeker_applied_for_job.answer,tbl_seeker_applied_for_job.file_name, tbl_post_jobs.employer_ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_companies.company_name, tbl_companies.company_logo, tbl_job_seekers.first_name, tbl_job_seekers.last_name, tbl_job_seekers.photo
	FROM `tbl_seeker_applied_for_job` aj
	INNER JOIN tbl_job_seekers ON aj.seeker_ID=tbl_job_seekers.ID
	INNER JOIN tbl_post_jobs ON aj.job_ID=tbl_post_jobs.ID
	INNER JOIN tbl_companies ON tbl_post_jobs.company_ID=tbl_companies.ID
	WHERE aj.seeker_ID=applicant_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_company_by_slug` (IN `slug` VARCHAR(70))  BEGIN
	SELECT emp.ID AS empID, pc.ID, emp.country, emp.city, pc.company_name, pc.company_description, pc.company_location, pc.company_website, pc.no_of_employees, pc.established_in, pc.company_logo, pc.company_slug
	FROM `tbl_employers` AS emp 
	INNER JOIN tbl_companies AS pc ON emp.company_ID=pc.ID
	WHERE pc.company_slug=slug AND emp.sts='active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_experience_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_experience.* 
	FROM `tbl_seeker_experience`
	WHERE tbl_seeker_experience.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_experience.start_date DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_featured_job` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
		SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug 
	FROM `tbl_post_jobs` pj 
	LEFT JOIN tbl_companies AS pc ON pj.company_ID=pc.ID 
	WHERE pj.is_featured='yes'
	ORDER BY ID DESC 
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_latest_posted_job_by_employer_ID` (IN `emp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_opened_jobs_home_page` (IN `from_limit` INT(5), `to_limit` INT(5))  BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posted_job_by_company_id` (IN `comp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.job_description, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.company_ID=comp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posted_job_by_employer_id` (IN `emp_id` INT(11), `from_limit` INT(4), `to_limit` INT(4))  BEGIN
		SELECT tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.job_slug, tbl_post_jobs.job_description, tbl_post_jobs.contact_person, tbl_post_jobs.contact_email, tbl_post_jobs.contact_phone, tbl_post_jobs.employer_ID, tbl_post_jobs.last_date, tbl_post_jobs.dated, tbl_post_jobs.city, tbl_post_jobs.is_featured, tbl_post_jobs.sts, tbl_job_industries.industry_name, pc.company_name, pc.company_logo
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.employer_ID=emp_id
	ORDER BY ID DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posted_job_by_id` (IN `job_id` INT(11))  BEGIN
		SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
,em.city as emp_city, em.country as emp_country
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
  INNER JOIN tbl_employers AS em ON pc.ID=em.company_ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posted_job_by_id_employer_id` (IN `job_id` INT(11), `emp_id` INT(11))  BEGIN
	SELECT tbl_post_jobs.*, pc.ID AS CID, tbl_job_industries.industry_name, pc.company_name, pc.company_email, pc.company_ceo, pc.company_description, pc.company_logo, pc.company_phone, pc.company_website, pc.company_fax,pc.no_of_offices, pc.no_of_employees, pc.established_in, pc.industry_ID AS cat_ID, pc.company_location, pc.company_slug
	FROM `tbl_post_jobs` 
	INNER JOIN tbl_companies AS pc ON tbl_post_jobs.company_ID=pc.ID
	INNER JOIN tbl_employers AS emp ON tbl_post_jobs.employer_ID=emp.ID
	INNER JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
	WHERE tbl_post_jobs.ID=job_id AND tbl_post_jobs.employer_ID=emp_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_qualification_by_jobseeker_id` (IN `jobseeker_id` INT(11))  BEGIN
	SELECT tbl_seeker_academic.* 
	FROM `tbl_seeker_academic`
	WHERE tbl_seeker_academic.seeker_ID=jobseeker_id 
	ORDER BY tbl_seeker_academic.completion_year DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `job_search_by_city` (IN `param_city` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.city = param_city AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `job_search_by_industry` (IN `param` VARCHAR(255), `from_limit` INT(5), `to_limit` INT(5))  BEGIN
	SELECT pj.ID, pj.job_title, pj.job_slug, pj.employer_ID, pj.company_ID, pj.job_description, pj.city, pj.dated, pj.last_date, pj.is_featured, pj.sts, pc.company_name, pc.company_logo, pc.company_slug
	FROM tbl_post_jobs pj
	INNER JOIN tbl_companies pc ON pc.ID = pj.company_ID 
	WHERE pj.industry_ID = param AND pj.sts = 'active' AND pc.sts = 'active'
	ORDER BY pj.dated DESC
	LIMIT from_limit, to_limit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_posted_jobs` (IN `where_condition` VARCHAR(255), `from_limit` INT(11), `to_limit` INT(11))  BEGIN
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
-- Structure de la table `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `calendar`
--

INSERT INTO `calendar` (`id_calendar`, `id_employer`, `id_job_seeker`, `notes`, `date`) VALUES
(3, 1, 10, 'Interview with Jhony Man', '2018-01-26 10:00:00'),
(4, 1, 10, 'aasasa', '2018-01-26 12:00:00'),
(5, 209, 423, 'Interview with Ram', '2018-02-27 10:00:00'),
(6, 209, 426, 'Interview with Ramtaniii', '2018-01-28 10:00:00'),
(7, 209, 423, 'Interview with Ram', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(8) NOT NULL,
  `admin_username` varchar(80) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_username`, `admin_password`, `type`) VALUES
(1, 'admin', '$2y$10$slp4AjsJfZdyzqVjL.xdk.h3FaR55VKqRFw2g4AdrzVvtR93nr8ve', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_ad_codes`
--

CREATE TABLE `tbl_ad_codes` (
  `ID` int(4) NOT NULL,
  `bottom` text,
  `right_side_1` text,
  `right_side_2` text,
  `google_analytics` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_ad_codes`
--

INSERT INTO `tbl_ad_codes` (`ID`, `bottom`, `right_side_1`, `right_side_2`, `google_analytics`) VALUES
(1, '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_cities`
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
-- Contenu de la table `tbl_cities`
--

INSERT INTO `tbl_cities` (`ID`, `show`, `city_slug`, `city_name`, `sort_order`, `country_ID`, `is_popular`) VALUES
(1, 1, '', 'New York', 998, 0, 'no'),
(2, 1, '', 'Dubai', 998, 0, 'no'),
(3, 1, '', 'Hong Kong', 998, 0, 'no'),
(4, 1, '', 'Islamabad', 998, 0, 'no'),
(5, 1, '', 'Lahore', 998, 0, 'no'),
(6, 1, '', 'California', 998, 0, 'no'),
(8, 1, '', 'Sydney', 998, 0, 'no'),
(9, 1, '', 'Los Angeles', 998, 0, 'no'),
(10, 1, '', 'Chicago', 998, 0, 'no'),
(11, 1, '', 'Houston', 998, 0, 'no'),
(14, 1, '', 'Stockholm', 998, 0, 'yes'),
(15, 1, '', 'San Francisco', 998, 0, 'no'),
(17, 1, '', 'Boston', 998, 0, 'no'),
(18, 1, '', 'Washington', 998, 0, 'no'),
(19, 1, '', 'Las Vegas', 998, 0, 'no'),
(25, 1, '', 'Malmö', 998, 0, 'no');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_cms`
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

CREATE TABLE `tbl_conversation` (
  `id_conversation` int(11) NOT NULL,
  `id_employer` int(11) DEFAULT NULL,
  `id_job_seeker` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_conversation`
--

INSERT INTO `tbl_conversation` (`id_conversation`, `id_employer`, `id_job_seeker`, `created_at`) VALUES
(3, 209, 423, '2018-01-25 10:36:22'),
(4, 209, 425, '2018-01-26 12:28:04'),
(5, 216, 427, '2018-01-26 13:17:54'),
(6, 209, 427, '2018-01-26 13:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_conv_message`
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
(27, 6, 209, 'ahlen', 'job_seekers', 0, NULL, '2018-01-26 13:41:58');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `ID` int(11) NOT NULL,
  `country_name` varchar(150) NOT NULL DEFAULT '',
  `country_citizen` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_countries`
--

INSERT INTO `tbl_countries` (`ID`, `country_name`, `country_citizen`) VALUES
(1, 'United States', 'United States'),
(2, 'United Kingdom', 'United Kingdom'),
(3, 'Australia', 'Australia'),
(4, 'Pakistan', 'Pakistan'),
(5, 'United Arab Emirates', 'United Arab Emirates'),
(6, 'China', 'China'),
(7, 'Canada', 'Canada'),
(8, 'Sweden', 'Swedish'),
(12, 'Egypt', 'Egyptian');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_email_content`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_employers`
--

INSERT INTO `tbl_employers` (`ID`, `company_ID`, `email`, `pass_code`, `first_name`, `last_name`, `country`, `city`, `mobile_phone`, `gender`, `dated`, `sts`, `dob`, `home_phone`, `verification_code`, `first_login_date`, `last_login_date`, `ip_address`, `old_emp_id`, `flag`, `present_address`, `top_employer`) VALUES
(209, 209, 'bixmatech@gmail.com', 'test123', 'Bixma', NULL, 'Sweden', 'Stockholm', '0046700775775', NULL, '2018-01-25', 'active', NULL, NULL, NULL, '2018-01-25 10:45:06', '2018-01-27 06:46:19', '90.224.199.144', NULL, NULL, NULL, 'yes'),
(210, 210, 'ayoub.ezzini3@gmail.com', 'ayoub123', 'Timéo Skarander', NULL, 'Sweden', 'N.A', '+23123140938', NULL, '0000-00-00', 'active', NULL, NULL, NULL, NULL, NULL, '105.71.136.97', NULL, NULL, NULL, 'yes'),
(211, 211, 'info@travos.se', 'mimo123', 'Attunda Tingsrätt', NULL, 'Sweden', 'Sollentuna', '0723189657', NULL, '0000-00-00', 'active', NULL, NULL, NULL, '2018-01-26 12:08:58', '2018-01-26 12:08:58', '83.183.12.57', NULL, NULL, NULL, 'yes'),
(212, 212, 'mimosweden@gmail.com', 'mimo123', 'Göteborgs tingsrätt', NULL, 'Sweden', 'Göteborg', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(213, 213, 'libanesen@hotmail.com', 'mimo123', 'Jönköpings tingsrätt', NULL, 'Sweden', 'Jönköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, '2018-01-27 07:27:49', '2018-01-27 07:27:49', '83.183.12.57', NULL, NULL, NULL, 'yes'),
(214, 214, 'timeo.skarander@hotmail.com', 'mimo123', 'Linköpings tingsrätt', NULL, 'Sweden', 'Linköping', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(215, 215, 'rekrytering@travos.se', 'mimo123', 'Eskilstuna tingsrätt', NULL, 'Sweden', 'Eskilstuna', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes'),
(216, 216, 'sfi@travos.se', 'mimo123', 'Malmö Tingsrätt', NULL, 'Sweden', 'Malmö', '0723189657', NULL, '2018-01-26', 'active', NULL, NULL, NULL, NULL, NULL, '83.183.12.57', NULL, NULL, NULL, 'yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_favourite_candidates`
--

CREATE TABLE `tbl_favourite_candidates` (
  `employer_id` int(11) NOT NULL,
  `seekerid` int(11) DEFAULT NULL,
  `employerlogin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_favourite_companies`
--

CREATE TABLE `tbl_favourite_companies` (
  `seekerid` int(11) NOT NULL,
  `companyid` int(11) DEFAULT NULL,
  `seekerlogin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `ID` int(11) NOT NULL,
  `image_caption` varchar(150) DEFAULT NULL,
  `image_name` varchar(155) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `sts` enum('inactive','active') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `tbl_institute` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sts` enum('blocked','active') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `tbl_job_alert` (
  `ID` int(11) NOT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_alert_queue`
--

CREATE TABLE `tbl_job_alert_queue` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `dated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_functional_areas`
--

CREATE TABLE `tbl_job_functional_areas` (
  `ID` int(7) NOT NULL,
  `industry_ID` int(7) DEFAULT NULL,
  `functional_area` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_industries`
--

CREATE TABLE `tbl_job_industries` (
  `ID` int(11) NOT NULL,
  `industry_name` varchar(155) DEFAULT NULL,
  `slug` varchar(155) DEFAULT NULL,
  `sts` enum('suspended','active') DEFAULT 'active',
  `top_category` enum('no','yes') DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_job_seekers`
--

INSERT INTO `tbl_job_seekers` (`ID`, `first_name`, `last_name`, `email`, `password`, `present_address`, `permanent_address`, `dated`, `country`, `city`, `gender`, `dob`, `phone`, `photo`, `default_cv_id`, `mobile`, `home_phone`, `cnic`, `nationality`, `career_objective`, `sts`, `verification_code`, `first_login_date`, `last_login_date`, `slug`, `ip_address`, `old_id`, `flag`, `queue_email_sts`, `send_job_alert`) VALUES
(8, 'Test Test', NULL, 'testtest123@gmail.com', 'testtest', 'here', NULL, '2016-03-12 01:44:43', 'Pakistan', 'Islamabad', 'male', '1990-01-01', NULL, 'test-test-JOBPORTAL-8.jpg', 0, '123123123', '123123123', NULL, '1', NULL, 'active', NULL, '2016-05-14 15:39:15', '2017-05-04 05:12:02', NULL, '2.50.150.100', NULL, NULL, NULL, 'yes'),
(9, 'Michel Jen', '', 'qwert@test.com', 'test123', 'n eu mattis mauris. Fusce fringilla imperdiet enim', '', '2016-03-12 01:51:56', 'United States', 'Malmö', 'male', '1988-04-09', NULL, 'no-image.jpg', 0, '123456789', '123456789', NULL, 'United States', NULL, 'active', NULL, '2018-01-25 09:45:14', '2018-01-26 14:01:43', NULL, '115.186.165.234', NULL, NULL, NULL, 'yes'),
(10, 'Jhony Man', '', 'etest@test.com', 'test123', 'Quisque ac scelerisque libero, nec blandit neque. Nullam felis nisl,', NULL, '2016-03-12 13:04:32', 'United States', 'Las Vegas', 'other', '1989-04-04', NULL, 'no-image.jpg', 0, '123456897', '', NULL, 'United States', NULL, 'active', NULL, '2018-01-24 16:40:19', '2018-01-27 05:57:29', NULL, '115.186.165.234', NULL, NULL, NULL, 'yes'),
(11, 'Kganxx', '', 'kganxx@gmail.com', 'Solutions123', 'PO Box 450125', NULL, '2016-03-28 14:11:09', 'Sweden', 'Malmö', 'male', '1988-05-31', NULL, 'no-image.jpg', 0, '152485145', '', NULL, 'United Arab Emirates', NULL, 'active', NULL, '2016-03-28 14:13:41', '2016-03-28 14:13:41', NULL, '2.49.65.117', NULL, NULL, NULL, 'yes'),
(12, 'KAcykos', NULL, 'kacykos1@gmail.com', 'kacper93', 'adadad', NULL, '2016-03-28 14:46:29', 'Pakistan', 'Abu Dhabi', 'male', '1980-11-14', NULL, 'no-image.jpg', 0, '23242424', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '83.27.161.159', NULL, NULL, NULL, 'yes'),
(13, 'ajay', NULL, 'jainmca4444@gmail.com', 'red@12321', 'ETS', NULL, '2016-03-28 17:40:38', 'Pakistan', 'Lahore', 'male', '1980-04-09', NULL, 'no-image.jpg', 0, '898989899', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '112.196.142.218', NULL, NULL, NULL, 'yes'),
(14, 'Peter Sturm', NULL, 'petersturm@bluewin.ch', 'petertester', 'Via Cantone', NULL, '2016-03-28 18:18:22', 'United States', 'new york', 'male', '1980-01-01', NULL, 'no-image.jpg', 0, '678768768768', '', NULL, 'United States', NULL, 'active', NULL, NULL, NULL, NULL, '46.127.154.34', NULL, NULL, NULL, 'yes'),
(411, 'gfgfgfhh', NULL, 'hassanayoub85@hotmail.com', 'zaq12wsx', 'dsfdgfghhghgfh', NULL, '2018-01-25 09:49:27', 'Australia', 'fdfdf', 'male', '1984-05-01', NULL, NULL, 0, '0000000', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '185.118.27.136', NULL, NULL, NULL, 'yes'),
(422, 'a', NULL, 'a@a.a', '123456', 'a', NULL, '2018-01-25 10:07:35', 'Australia', 'a', 'male', '1985-04-15', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '41.142.0.106', NULL, NULL, NULL, 'yes'),
(423, 'Ram', '', 'mailramzi@gmail.com', 'test123', 'Sweden', NULL, '2018-01-25 10:27:02', 'Sweden', 'Linköping', 'male', '1979-02-27', NULL, NULL, 0, '0046700775775', '', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-25 10:31:27', '2018-01-27 07:35:43', NULL, '90.224.199.144', NULL, NULL, NULL, 'yes'),
(424, 'Ayoub Ezzini', '', 'a37killer@gmail.com', 'ayoub123', 'N/A', NULL, '2018-01-25 14:08:33', 'Sweden', 'Göteborg', 'male', '1997-09-06', NULL, 'ayoub-ezzini-JOBPORTAL-424.jpg', 0, '+212623357087', '', NULL, 'United Kingdom', NULL, 'active', NULL, NULL, NULL, NULL, '105.71.136.97', NULL, NULL, NULL, 'yes'),
(425, 'Kali Linux', '', 'ayoub.ezzini@gmail.com', '123456', 'Centralvägen 1, 171 68 Solna', NULL, '2018-01-26 06:02:03', 'Sweden', 'Eskilstuna', 'other', '1993-08-20', NULL, NULL, 0, 'a', 'a', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '105.156.230.57', NULL, NULL, NULL, 'yes'),
(426, 'Ramtaniii', '', 'ram@gmail.com', 'test123', 'Centralvägen 1, 171 68 Solna', 'ghjkl;', '2018-01-26 12:31:56', 'Sweden', 'Malmö', 'male', '1980-04-05', NULL, NULL, 0, '763356790', '', NULL, 'Australia', NULL, 'active', NULL, NULL, NULL, NULL, '90.224.199.144', NULL, NULL, NULL, 'yes'),
(427, 'Tim S', NULL, 'sfi@travos.se', 'mimo123', 'Centralvägen 1', NULL, '2018-01-26 13:01:10', 'Sweden', 'Solna', 'male', '1976-10-04', NULL, NULL, 0, '0723189657', '0723189657', NULL, 'Swedish', NULL, 'active', NULL, '2018-01-26 13:26:31', '2018-01-27 08:21:27', NULL, '83.183.12.57', NULL, NULL, NULL, 'yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_job_titles`
--

CREATE TABLE `tbl_job_titles` (
  `ID` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
-- Structure de la table `tbl_post_jobs`
--

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(118, 213, 'Advokat', 213, 42, '31000-35000', '2018-01-27', 'active', 'no', 'Sweden', '2018-02-28', '', 'BA', 'Fresh', 'Jönköping', 'Part Time', 10, 'advokat, word', '', '', '', 0, 'jnkpings-tingsrtt-jobs-in-jönköping-advokat-118', '2.65.17.62', NULL, NULL, 'advokat, word', 0, '', 'advokat', '', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_prohibited_keywords`
--

CREATE TABLE `tbl_prohibited_keywords` (
  `ID` int(11) NOT NULL,
  `keyword` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `tbl_qualifications` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `tbl_salaries` (
  `ID` int(5) NOT NULL,
  `val` varchar(25) DEFAULT NULL,
  `text` varchar(25) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `tbl_scam` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `job_ID` int(11) DEFAULT NULL,
  `reason` text,
  `dated` datetime DEFAULT NULL,
  `ip_address` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Contenu de la table `tbl_seeker_academic`
--

INSERT INTO `tbl_seeker_academic` (`ID`, `seeker_ID`, `degree_level`, `degree_title`, `major`, `institude`, `country`, `city`, `completion_year`, `dated`, `flag`, `old_id`) VALUES
(1, 10, NULL, 'BA', 'test', 'teste e ere', 'United States of America', 'New york', 2012, '2016-03-12 13:05:55', NULL, NULL),
(37, 423, NULL, 'BS', 'software', 'IT institute', 'Paraguay', 'kep', 2022, '2018-01-25 11:36:30', NULL, NULL),
(38, 10, NULL, 'BE', 'NOTHING', 'Like', 'Pakistan', 'Job', 2023, '2018-01-27 03:26:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_additional_info`
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
(356, 427, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_applied_for_job`
--

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(251, 423, 118, 'Gjfx', 'Trainee Stipend', '2018-01-27 07:36:22', NULL, 213, NULL, NULL, NULL, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_experience`
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
-- Contenu de la table `tbl_seeker_experience`
--

INSERT INTO `tbl_seeker_experience` (`ID`, `seeker_ID`, `job_title`, `company_name`, `start_date`, `end_date`, `city`, `country`, `responsibilities`, `dated`, `flag`, `old_id`) VALUES
(1, 9, 'test', 'testete', '2012-02-16', NULL, 'New york', 'United States of America', NULL, '2016-03-12 02:10:41', NULL, NULL),
(60, 423, 'Developer', 'teslok', '2019-01-02', '2018-01-11', 'gooda', 'St Vincent & Grenadines', NULL, '2018-01-25 11:35:42', NULL, NULL),
(61, 10, 'Developer', 'SURNATUREL', '2018-01-25', NULL, 'Nice', 'Macau', NULL, '2018-01-27 03:26:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_resumes`
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
-- Contenu de la table `tbl_seeker_resumes`
--

INSERT INTO `tbl_seeker_resumes` (`ID`, `seeker_ID`, `is_uploaded_resume`, `file_name`, `resume_name`, `dated`, `is_default_resume`) VALUES
(1, 8, 'yes', 'test-test-8.docx', NULL, '2016-03-12 01:44:43', 'no'),
(2, 10, 'no', 'michel-jen-9.docx', NULL, '2016-03-12 01:51:56', 'no'),
(4, 10, 'yes', 'jhony-man-JOBPORTAL-101457770070.docx', 'Ayoub', '2016-03-12 13:07:50', 'yes'),
(5, 11, 'yes', 'kganxx-11.docx', NULL, '2016-03-28 14:11:09', 'yes'),
(6, 12, 'yes', 'kacykos-12.jpg', NULL, '2016-03-28 14:46:29', 'no'),
(7, 13, 'yes', 'ajay-13.txt', NULL, '2016-03-28 17:40:38', 'no'),
(8, 14, 'yes', 'peter-sturm-14.pdf', NULL, '2016-03-28 18:18:22', 'no'),
(361, 411, 'yes', 'gfgfgfhh-411.docx', NULL, '2018-01-25 09:49:27', 'no'),
(362, 422, 'yes', 'a-422.pdf', NULL, '2018-01-25 10:07:35', 'no'),
(363, 423, 'yes', 'ram-423.rtf', NULL, '2018-01-25 10:27:02', 'no'),
(365, 424, 'yes', 'ayoub-ezzini-424.pdf', NULL, '2018-01-25 14:08:33', 'no'),
(366, 425, 'yes', 'kali-linux-425.pdf', NULL, '2018-01-26 06:02:03', 'no'),
(367, 426, 'yes', 'ramtan-426.rtf', NULL, '2018-01-26 12:31:56', 'no'),
(368, 427, 'yes', 'tim-s-427.doc', NULL, '2018-01-26 13:01:10', 'no');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_seeker_skills`
--

CREATE TABLE `tbl_seeker_skills` (
  `ID` int(11) NOT NULL,
  `seeker_ID` int(11) DEFAULT NULL,
  `skill_name` varchar(155) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(984, 424, 'php'),
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
(1006, 10, 'php');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_sessions`
--

CREATE TABLE `tbl_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tbl_sessions`
--

INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('00cg28cnrhrssouvo39tc1dfm0iqv2ch', '94.234.38.153', 1516968246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383234363b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('015jmd98aj2i5ucj7bk20hi32i05d0h6', '66.249.66.21', 1517010666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303636363b),
('024mb7kivvjmaslgkl7qr0p7e6skhf71', '90.224.199.144', 1516899170, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393137303b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231303a33363a3433223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('02r6gq15qc73kph8vs5lp81atabbpjcb', '195.110.34.50', 1516994384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343338343b),
('05r4sdoh8ih6phjbv7lvg6vfam6g09dl', '66.249.66.22', 1517010526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303532363b),
('07vh1hsok6scf33s72vfhihhkes6j4gj', '41.143.187.214', 1517051880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035313838303b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('08513foff6fvi50gahvpgu74hf5rj6lc', '195.110.34.50', 1517004932, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343933323b),
('0a6ng7t7e7if8vhri1q26irsa60rcpbu', '41.142.0.106', 1516903527, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333532373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b636170576f72647c733a353a224553354631223b),
('0co682krlmcvcstqk2el5hpn375egvps', '195.110.34.50', 1516993794, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333739343b),
('0dmmmntr388s8m0ka63il0lb3hh2v49o', '195.110.34.50', 1517000504, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303530343b),
('0e8ektbpf3pp6ss69nd192sabj8h8jtb', '41.143.187.214', 1517047451, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373435313b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539356236333565223b75736572656d61696c7c733a303a22223b),
('0ec57inqemslg53vi035ivj0eea4vtil', '105.156.230.57', 1516968147, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383035303b757365725f69647c733a303a22223b757365725f656d61696c7c733a32323a2261796f75622e657a7a696e6940676d61696c2e636f6d223b66697273745f6e616d657c733a31303a224b616c69204c696e7578223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b636170576f72647c733a353a22314b594b42223b6c6173745f6e616d657c733a303a22223b),
('0i0ajtr7b2973hvp3oufmlovo4ts84am', '105.71.136.97', 1516911621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931313632313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b757365725f69647c693a3432343b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223252465634223b6c6173745f6e616d657c733a303a22223b),
('0jve3ack9aa3uibq7nurrubg9hch9q64', '83.183.12.57', 1516990788, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303738383b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a32303a226d696d6f73776564656e40676d61696c2e636f6d223b66697273745f6e616d657c733a32313a2247c3b67465626f7267732074696e677372c3a47474223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a4b5439223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('0mnth1mcaris4c4t8ud5snlp81f6ltu6', '195.110.34.50', 1516995837, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353833373b),
('0olfqva0isjembv5vum29u8q5a2837hn', '195.110.34.50', 1516994560, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343536303b),
('0pcssd125qeekn6dn0rn0olh322ord56', '41.143.187.214', 1517051414, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035313431343b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('0pmf0ohktdpcp8fcp2mp387af7nh0gvh', '195.110.34.50', 1516991821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313832313b),
('0sqsdhtar0sp0rmqig0b1ohugoipfeuc', '60.191.38.78', 1516939320, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363933393332303b),
('0te4hdahd3upuc6j6l3vco0qjh80122r', '195.110.34.50', 1517055007, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353030373b),
('106dm7atjst0urs6n21ca7jue63141or', '66.249.66.19', 1516903971, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333937313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34393a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d646576656c6f7065722d3131343f73633d796573223b),
('10hqe3caiah0rcongu5mfo80hk0ndegi', '195.110.34.50', 1516990634, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303633343b),
('10vfhte6f3js10ucam4iq8irousego08', '105.71.128.223', 1516994975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343937353b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2242345738223b),
('11pm2k755m0jpjo485v5g24t34gu4k4s', '::1', 1494503562, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439343530333439303b637074636f64657c733a343a224e325735223b),
('13vfgedugejluhem13s042303pnf90a6', '195.110.34.50', 1516992656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323635363b),
('175alfffemf3tqi0r474cm57r34pgml7', '190.94.138.4', 1516899734, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393733343b),
('176ugj5ssb7vi2vl23fqbe5ge304dv80', '105.71.136.97', 1516911115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931313131353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2242345738223b757365725f69647c693a3432343b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223252465634223b6c6173745f6e616d657c733a303a22223b),
('1c2g5flkkic8jhktlj1u7p12tcci0gsj', '108.171.101.195', 1517049275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393237353b),
('1ch1j174gb6q5ih3n91ah9q8p16ng10l', '66.249.66.137', 1517030017, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373033303031373b),
('1e5udjsk8poo9a8m41rtggq0sje2du76', '195.110.34.50', 1517004646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343634363b),
('1ij1v8m4vk3ofjmrg2itadaum65bsia7', '90.224.199.144', 1516996934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363933343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('1k049uvsgpgu0s1kgg96goaakkgjitob', '185.118.27.136', 1517059977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035393932303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353934363566336434393466223b),
('1k3kujnpfgfvni5ido4fkkge15jstv92', '195.110.34.50', 1517000763, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303736333b),
('1oo83ftoejn209982edfikh28k2ho5sg', '185.118.27.136', 1516996866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363836363b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('1oq2rkml7ucp0vlth3a3k5t3pq09g7e4', '158.174.4.45', 1516916929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931363932393b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a373a2265676f2d646576223b637074636f64657c733a343a2247374b35223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b),
('1qit5fract4qpvrdi023ktctna7cudvn', '195.110.34.50', 1517051936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035313933363b),
('1qpdci9nituc4pvua132gii476i1f5dt', '66.249.64.202', 1516962874, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936323837343b),
('1u1c57rs086cg09o829dmgtifiru2k8e', '90.224.199.144', 1516990674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303637343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2247374b35223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a2250535a5a42223b),
('1v70eh4uutaf4q7ntdsiv097of7k38ak', '83.183.12.57', 1516989738, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393733383b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31363a2254696dc3a96f20536b6172616e646572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32313a22656d706c6f7965722f706f73745f6e65775f6a6f62223b736c75677c733a393a22747261766f732d6162223b),
('1vog1l55s0gql9unc29nl9ghk8k5i16t', '105.156.230.57', 1516959748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393734383b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2242345738223b),
('23fe31h2r90dkes8o8v4frntrope0oiv', '41.143.187.214', 1517049253, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393235333b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('25u9ojp5o608euhmi2tmdhqd03vvgad7', '96.47.226.22', 1517061479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036313437393b),
('293t3umc7n68lsmvfdfqbmrt8nl0kuoo', '105.156.230.57', 1516988859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383835393b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a36343a226a6f62732f6d6567612d746563686e6f6c6f676965732d6a6f62732d696e2d6e6577253230796f726b2d7068702d646576656c6f7065722d323f73633d796573223b637074636f64657c733a343a2247374b35223b75736572656d61696c7c733a303a22223b),
('29ecobcv10mht950rgqnleerbbbvo8qd', '41.142.0.106', 1516896490, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363437343b),
('2eqfq9m7ftsb200brph3g3kl3adusigr', '195.110.34.50', 1517055014, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353031343b),
('2h6e5uvb2497k4918k7p3tb9o2bhlej7', '66.249.66.21', 1516908499, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930383439393b),
('2imvqqm8nfcsrf05ntffafb9cg9mcfku', '195.110.34.50', 1517055016, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353031363b),
('2m7oafuc2otdpfvf8kt5g30vnpedde7p', '41.142.0.106', 1516896384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363338343b636170576f72647c733a353a224742343758223b),
('2n6o6v7jcg51fre1lpn013630jpe9p63', '105.71.128.223', 1516999239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393233393b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b7570646174655f616374696f6e7c623a313b5f5f63695f766172737c613a313a7b733a31333a227570646174655f616374696f6e223b733a333a226f6c64223b7d),
('2nk3ico92lign5v5533utlsnebau8jmp', '90.224.199.144', 1516991917, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313931373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c693a3432363b757365725f656d61696c7c733a32313a2272616d7a6974616e616e6940676d61696c2e636f6d223b66697273745f6e616d657c733a363a2252616d74616e223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('35p4k1ed5bk2qdt3k5qms356i35rdttp', '90.224.199.144', 1516904504, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930343234303b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('365289f57d170ra09eol2qtaggtrbc9d', '195.110.34.50', 1516989472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393437323b),
('36q2lac6fdfaar49216u4s19hq7qii6i', '66.249.66.22', 1516903954, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333935343b),
('39lcclgtm3pebrju0nv2odf2i708jus8', '66.249.66.85', 1517053702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035333730323b),
('3a7rt88fk1f93ti5oi82bcgjhvsm82k9', '195.110.34.50', 1517062934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323933343b),
('3aiq1fp6vlefu3bmqbobmvn3trco11bf', '195.110.34.50', 1517054499, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439393b),
('3av63cobuh0ul4epthtste8vuga1p4j9', '195.110.34.50', 1517000671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303637313b),
('3bejcm8lmpbu2g314lrjjoqjhc3mn3u3', '195.110.34.50', 1517005182, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353138323b),
('3biatmq996gdf2ca9n27ofs9hkpf715d', '66.249.66.19', 1516903952, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333935323b),
('3co32nser3n5n427vfe4sapm2pufh158', '195.110.34.50', 1517054674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343637343b),
('3ep8ic2aik2dbkgbmedb0q5p0tkgc95v', '83.183.12.57', 1516991098, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313039383b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c693a3231343b757365725f656d61696c7c733a32373a2274696d656f2e736b6172616e64657240686f746d61696c2e636f6d223b66697273745f6e616d657c733a32323a224c696e6bc3b670696e67732074696e677372c3a47474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a31383a226c696e6b70696e67732d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a225a344e3647223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2242345738223b),
('3evbtn3hl48l4b7s0aktu6c9tnprclc0', '91.233.241.253', 1516912973, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323937333b),
('3fcr3qcai7aeria3ag67rfudonmnafb7', '66.249.64.204', 1516926687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363932363638373b),
('3g0g9t8dd6u3vvnm4pdnine6r7d68ck1', '195.110.34.50', 1516981033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313033333b),
('3g5jvvfika1jjaiihd45nm78pr09avjo', '83.183.12.57', 1516990110, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303131303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c693a3231313b757365725f656d61696c7c733a31343a22696e666f40747261766f732e7365223b66697273745f6e616d657c733a31313a224d696d6f2053776564656e223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32313a22656d706c6f7965722f706f73745f6e65775f6a6f62223b736c75677c733a31363a22617474756e64612d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a225657453631223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2254394c34223b),
('3hkut2nppfli68fqt2p5t3joqjcb7hp2', '66.249.66.21', 1517008911, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030383931313b),
('3ir7a4q0c1jlvm884qectpggg7jk02v7', '90.224.199.144', 1516991609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313630393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2242345738223b),
('3kajees12ufd7dng86nbt4krtda34q3j', '195.110.34.50', 1517054761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343736313b),
('3m1mobhb6iqkvetesgmmmoeb9j4gmvkf', '66.249.64.202', 1517000869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303836393b),
('3mr9vct8b2hgg8tbpmk23agqt5ritfgd', '66.249.66.19', 1516903973, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333937333b),
('3nfk7p852ss4sv4gq5kon6tbno2pf9qc', '105.71.128.223', 1517005165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353136353b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('3o7f1n3gsuf8pgp54vmnpg3cidbosq7m', '90.224.199.144', 1516898669, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839383636393b636170576f72647c733a353a22515a325a42223b757365725f69647c693a3230393b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231303a33363a3433223b),
('3pnbaqe5jnrvud9b16o6t4ej53g43ou9', '84.219.189.69', 1516990955, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303935353b),
('3pqalegfo1qc7ht44oc91qkfb35om3nk', '195.110.34.50', 1516999606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393630363b),
('3soui5eqtk5sudt6uu3k3kd63sb2aeof', '83.183.12.57', 1516994524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343532343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2254394c34223b),
('3ugv1r1e3s38p3ligni66014i9lgv1kb', '2.65.17.62', 1517063261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036333230393b636170576f72647c733a353a225a4a454459223b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b),
('46455obvlfktr6gmcdd16rr2u5ssc54l', '185.118.27.136', 1517059920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035393932303b),
('47tdo7tmctg7g9gmunq946lv5l7vdjco', '66.249.66.22', 1516890311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839303331313b),
('4fg6llpnd2kha85bh5809s2h8tvqcc9v', '90.224.199.144', 1516903929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333932393b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('4mrb8ojl3aa0u8erg2k8t21i5k0dcasv', '195.110.34.50', 1516999872, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393837323b),
('4ou1cose6aku5f9jemk2ap78sc5f6iv4', '66.249.64.200', 1516953969, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935333936393b),
('4pir9svdcd475ouqdt6t3ekhihe23i3a', '105.156.230.57', 1516961008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936313030383b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31333a22656d706c6f7965722f63686174223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2258334644223b),
('4por3g2cih79h90r308so9jnvhn8oige', '195.110.34.50', 1516981456, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313435363b),
('502u97l4stb6iknlhneer57kjulqm0du', '66.249.66.19', 1516873482, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333438323b),
('50j5782q3nj0cd785f7as99qp23e11qu', '195.110.34.50', 1517052946, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323934363b),
('52365aclt3mjkghltug8cv6jnj2olmnj', '66.249.66.19', 1517010954, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303935343b),
('54jak4mdte6fa1lqbrguqi2holt17bjk', '41.142.0.106', 1516894847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839343537343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35343a226a6f62732f6a6b6c2d636f6d70616e792d6a6f62732d696e2d6e6577253230796f726b2d677261706869632d64657369676e65722d39223b),
('591bop9l9o7v497ag22lse0826b37su2', '66.249.66.22', 1516881224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363838313232343b),
('59om55j67ht43r51nrbbhf6lsuc5aifm', '195.110.34.50', 1516990648, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303634383b),
('5d523ohlnmnkrtrtdmo3g3ghm5gilvs4', '90.224.199.144', 1516995830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353833303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2242345738223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('5da225dpnp3uahhnq5abae9cuaqjcf6b', '195.110.34.50', 1517052959, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323935393b),
('5e1b1af9emtmtgcv8mgp90ep1hhe27po', '83.183.12.57', 1516989351, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393335313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31363a2254696dc3a96f20536b6172616e646572223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32313a22656d706c6f7965722f706f73745f6e65775f6a6f62223b736c75677c733a393a22747261766f732d6162223b),
('5eb22mt4jov6c080fcsq5hfvj0o6o1kn', '66.249.64.204', 1516940705, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303730353b),
('5eoubbb2ijpc4if5vq5d85c43kqvidr0', '105.71.128.223', 1517010997, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303939373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('5gh9v4e9vdfgbmt2bclb9tg9f4s3bnt5', '185.118.27.136', 1517058880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035383838303b),
('5ki7oq71o82o2rhvs7s15hi1od5vu6tc', '195.110.34.50', 1516959085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393038353b),
('5l32sm3md95nrc7sne4sj4jd50mjo2ga', '91.233.241.253', 1516912974, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323937343b),
('5lbvme77iogfk1jbvuo2gmamespc313p', '195.110.34.50', 1516993329, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333332393b),
('5lhjqb213bt3a5evp7r1kvo9r63di9io', '195.110.34.50', 1516981430, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313433303b),
('5lp1sedldge0dg4hsi8tvr6hptakbdca', '195.110.34.50', 1517043941, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333934313b),
('5m2n0pkg8vcgmqcq3lhm3l40aavct2p1', '195.110.34.50', 1516995032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353033323b),
('5m4jjsee0sd12ai4iomibp7849ivjccm', '195.110.34.50', 1517004996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343939363b),
('5naa7arfj98eqdlkao8gvmqv58n8vpld', '90.224.199.144', 1516992207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323230373b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('5o5gsl5agrkgqsos8m0mle0gpcf99cd0', '66.249.64.204', 1516997524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373532343b),
('5p6smnpj7vdp99gidhb97l74don3c4m8', '90.224.199.144', 1516899896, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393839363b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231303a33363a3433223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('5pk6bjbbbimn9t48auqr77hms9gs0qg5', '158.174.4.45', 1516916251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931363235313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a373a2265676f2d646576223b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31373a226a6f627365656b65722f6d795f6a6f6273223b),
('5q8peh5i20p73721gumjtjg8042jo3gf', '83.183.12.57', 1516988820, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383832303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343235223b757365725f656d61696c7c733a32323a2261796f75622e657a7a696e6940676d61696c2e636f6d223b66697273745f6e616d657c733a31303a224b616c69204c696e7578223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32313a22656d706c6f7965722f706f73745f6e65775f6a6f62223b),
('5rbcn23t6e55145k1is6s60g8t1t9np3', '66.249.66.21', 1516873457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333435373b),
('5sa9a63f3thqq2s0c6h3gjoh2e7u3p01', '41.142.0.106', 1516896217, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363130363b636170576f72647c733a353a223245433444223b),
('5tjd3f2h6ctspbo50rtvcj43uuc08k6c', '41.143.187.214', 1517047760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373736303b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539356236333565223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('5udc7idcquikua7qgl0aqg0s9nua8sp9', '83.183.12.57', 1516995770, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353737303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224254364a51223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a224e325735223b),
('603aif3ivm9fj31tffkjnb76f24nfvqq', '195.110.34.50', 1517055000, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353030303b),
('60a9hikjs4u2o31q6oe7mqrgcmd3is1n', '177.75.221.75', 1516985807, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938353830373b),
('61tkobprrmf20vvmoaspo8c1grtmerci', '195.110.34.50', 1517054178, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343137383b),
('647qjjj2ukrip03991pu7dvo9efcv7i1', '41.143.187.214', 1517047804, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373830343b),
('66r0q2qilgq67vebd238assmd3pq9e3b', '66.249.66.157', 1517017325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031373332353b),
('68t3rs4t9mduhvlr070bcvurmrheccr2', '195.110.34.50', 1516999568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393536383b),
('69g41q3trb0ursbalmj3p01p936g5an4', '66.249.64.200', 1516963070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936333037303b),
('6a5semq2cjd648404pqk65shm4n9i051', '185.118.27.136', 1516998455, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383435353b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('6bg38jt2ug5j6dumoqntthkdssk3r2te', '66.249.66.21', 1516873593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333539333b),
('6hunr8ojqvr6c2hsjkcpfpe69kfr0gar', '66.249.66.22', 1517030966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373033303936363b),
('6i93u66e6kkjkerq4gdtaglbqlvariif', '41.143.187.214', 1517052946, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323934363b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('6ik9f475rrcnb8mnkmm998jdmjn8q6s4', '83.183.12.57', 1516993494, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333439343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2258334644223b),
('6javat53hj9sj6dfsda43j2fi8n9as4l', '195.110.34.50', 1517000260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303236303b),
('6ksolacv2toph41fffjrbpf47shb7pue', '195.110.34.50', 1516996697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363639373b),
('6pffoqg3u0g92d658jpoggiuc6tp2pkd', '83.183.12.57', 1516991464, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313436343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a32313a2272656b7279746572696e6740747261766f732e7365223b66697273745f6e616d657c733a32313a2245736b696c7374756e612074696e677372c3a47474223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2258334644223b),
('6pggkvqmpcuj8cst3r52r58t852micsn', '105.156.230.57', 1516966258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936363235383b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b),
('6r9mkuqdh1bggunj7r8ddupar5q38tql', '83.183.12.57', 1516991787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313738373b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a31373a224d616c6dc3b62054696e677372c3a47474223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('6rff12t5rg9covvi5if82lku3fjvq2gg', '41.143.187.214', 1517055040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343937323b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('6tb54qduhaschs09r894fklfeu9tfrio', '105.156.230.57', 1516957212, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935373231323b),
('6topp5g9cnkc8iv46nt2522aa17tgpvn', '90.224.199.144', 1516904188, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930343034323b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231313a30353a3234223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('72fmqv2nromhrt30qgavh8vrq4d7jd14', '90.224.199.144', 1516996556, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363535363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2242345738223b75736572656d61696c7c733a303a22223b6d73677c733a3135373a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e3c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e3c7374726f6e673e53756363657373213c2f7374726f6e673e204a6f6220686173206265656e2075706461746564207375636365737366756c6c792e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('74u1hufad70j2pt6v8ftmimbro9grice', '66.249.64.204', 1516988431, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383433313b),
('779b8e2m6cl4d4qbulim1sb3a28b8kdn', '188.19.87.216', 1516903398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333339383b),
('77ckhl5htpcnu3rgtql6d6ikmmainf3h', '66.249.66.21', 1516873538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333533383b636170576f72647c733a353a2233574b3559223b),
('77m7eivaplccncua0av3j11r59uba9lc', '195.110.34.50', 1516959107, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393130373b),
('7969kuhhkjp2ua65l514vvoff5lsrt6v', '66.249.64.202', 1516962803, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936323830333b),
('79qm4qvc10tju5f97uegqtdbbfbkpatd', '195.110.34.50', 1517000503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303530333b),
('7aa6mtrq2evv3q8m30bop0ohqq3rdjjp', '195.110.34.50', 1517053886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035333838363b),
('7dqbqb1knqtphh6qq15932el7vbr6fca', '90.224.199.144', 1516899111, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393131313b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b637074636f64657c733a343a2254394c34223b),
('7fthdn79l5lpr6rctf8iqt2fv81i47s5', '105.71.128.223', 1516998333, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383333333b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('7g9lhbd4ge7o2btjse4t40se9v1740qq', '66.249.64.204', 1516983964, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938333936343b),
('7gcvrkeco4ssm8n2ersgmg4pp16b94nq', '185.118.27.136', 1517058873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035383837333b),
('7hm7m7emtgd7efrdbg8a9gv6crjf69bf', '164.52.24.140', 1516848970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363834383937303b),
('7hvjfjcmhil242f69cre0m5hiq9js75n', '195.110.34.50', 1517054460, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343436303b),
('7lm8gh3fucnhku6flal6sh14ufiq5mmc', '195.110.34.50', 1516999460, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393436303b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('7opafn02hbsi8gpno1odfssmqpui8nsb', '41.143.187.214', 1517051066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035313036363b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f63765f6d616e61676572223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b6d73677c733a3136373a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e3c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e3c7374726f6e673e53756363657373213c2f7374726f6e673e204a6f622041647665727469736520686173206265656e2075706461746564207375636365737366756c6c792e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('7seaaipqbl90rgk1uv156s620s8s1gt8', '105.71.128.223', 1516997703, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373730333b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32353a22656d706c6f7965722f6a6f625f6170706c69636174696f6e73223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('80qtu4bctad0d28mmi6mg7225o4umf0j', '94.234.38.153', 1516968202, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383230323b),
('81asforhm67nt0811fi0gt4at82o3jep', '195.110.34.50', 1517063209, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036333230393b),
('81fpuuvpcpv0euffch4dhptk2llbtf2g', '66.249.66.85', 1517058248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035383234383b),
('85ddt9qv7l7j8q1fs5h3n53kfaap52q2', '66.249.66.202', 1517012778, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031323737383b),
('87s99cbovp1qs47dtl7sb3bgli0mra6b', '90.224.199.144', 1516997097, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363933343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('88ecoon08q9rg6ujoi7kpvuei1i5afgt', '90.224.199.144', 1516904240, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930343234303b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('8aoc3tglsef2on9iqcoehsak3b8j2s7q', '190.94.140.88', 1517062584, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323538343b),
('8dg5ehn4s6ch0fmvpu9pctm9v8s3kpa4', '195.110.34.50', 1516994479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343437393b),
('8ftpvraf49o8g0gb6tfivq3o3glh2amc', '105.156.230.57', 1516956542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935363534323b),
('8gvp5hhq8qs31s9ef8vhbrdcm5tlmf8b', '195.110.34.50', 1517004697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343639373b),
('8i3mfpcipub22nteh2hinrgejvnl8h1m', '195.110.34.50', 1516995583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353538333b),
('8ie45jc0imgp7novjsrechv219fq5sc4', '195.110.34.50', 1517005196, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353139363b),
('8kiuqrv8usb1d2j4vpiqlg0dbmf31uor', '90.224.199.144', 1516903082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333038323b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('8nh7dac1o4ibmv9u92hlopua424e8kcp', '2.65.17.62', 1517060011, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303031313b757365725f69647c733a333a22323133223b757365725f656d61696c7c733a32313a226c6962616e6573656e40686f746d61696c2e636f6d223b66697273745f6e616d657c733a32333a224ac3b66e6bc3b670696e67732074696e677372c3a47474223b736c75677c733a31373a226a6e6b70696e67732d74696e6773727474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b6d73677c733a3136303a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e3c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e3c7374726f6e673e53756363657373213c2f7374726f6e673e204e6577206a6f6220686173206265656e20706f73746564207375636365737366756c6c792e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('8qkgbmu9oce1q0b119l2t3hdgqk9v388', '62.119.166.1', 1516952263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935323231313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('8qlta5in9m7hcnkdp7ulos14uogu4718', '195.110.34.50', 1516995012, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353031323b),
('8rp5v5nrns8b7meosdaf1af0cmrh7i5n', '195.110.34.50', 1516995849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353834393b),
('91evfptu48c926l528qb4l3jou620g4i', '105.71.128.223', 1517013477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031333437373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('93eccckrcac1b30qmcc12upj05uld9tl', '54.173.161.144', 1517004892, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343839323b),
('96t7q0ln3m2n9rlekrrk50td3qetv0c0', '195.110.34.50', 1516999574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393537343b),
('98gtk3lolk47sbutn9lm89gopq9q9aln', '41.142.0.106', 1516903579, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333532373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2254394c34223b636170576f72647c733a353a224553354631223b),
('997du6hp4c8cn40beik7rt75sfqo52o4', '105.71.128.223', 1516995429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353432393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b),
('99kum0staq196d9sniu6apfh4q2c3pk0', '90.224.199.144', 1516995197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353139373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('9d9rc55rtbq1qolm9ju4i3fvm0b304n3', '195.110.34.50', 1517043850, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333835303b),
('9f2ocm2evrdlbiv41ct6n0pif1pqhcqq', '90.224.199.144', 1516902764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930323736343b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('9g0f76n9fvlnih0lohi3kjhjfmlij0ri', '195.110.34.50', 1517005265, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353236353b),
('9h71b2nb009m8ott193vm7jn34e287fb', '2.65.17.62', 1517063209, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036333230393b636170576f72647c733a353a225a4a454459223b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b),
('9i0rqranscaj3te7oummh8q6r45arsee', '158.174.4.45', 1516912310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323331303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('9j5kahpe6mpqefs5l42929ncmhhnj1f5', '41.143.187.214', 1517048253, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034383235333b),
('9k58bpn6ol5082lt9c8rdaep9f83dgq5', '195.110.34.50', 1516997001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373030313b),
('9m8fm7cbdkvqtdjpi2jlnqsahb4ktukf', '41.143.187.214', 1517048308, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034383330383b),
('9o77cfvcfgjehfcufniphc2ab3sllt86', '201.238.154.92', 1516973022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937333032323b),
('9oq77nnsb1dhkl35pos9m2l2hgrkcd1c', '177.75.221.75', 1516985821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938353832313b),
('9p68449j01ifhg6i3c9uek3hr3e7fuum', '195.110.34.50', 1516999575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393537353b),
('9tqngullcrdafhg6ltkjf9ng25rtblti', '195.110.34.50', 1517043753, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333735333b),
('9ur5vmsmpoe1d4elq4dvuq3pd8vm8705', '195.110.34.50', 1517004983, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343938333b),
('a1pa0r6dndmo2os2vigq93igb2n47s74', '190.94.138.4', 1516899737, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393733373b),
('a2qoa4cr2db6om2sfja8rfpjobum3fok', '90.224.199.144', 1516900825, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303832353b757365725f69647c733a313a2232223b757365725f656d61696c7c733a31353a2274657374324074657374322e636f6d223b66697273745f6e616d657c733a363a22416e64726577223b736c75677c733a393a2269742d706978656c73223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b637074636f64657c733a343a2247374b35223b),
('a3ro01bbav1nku1lr5pj2re78rom974f', '195.110.34.50', 1517004977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343937373b),
('a6p487tgvjsdp5rak7g9jgvt9tislac3', '41.143.187.214', 1517050141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035303134313b),
('a726oo25la8va8pgf1mc9nv8kiga8v5b', '195.110.34.50', 1517052173, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323137333b),
('a726qt1lc4tj41sclodaf8sujqeo8a8b', '195.110.34.50', 1517062922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323932323b),
('a9lsunf9rcisu9cd4cn0uktbj5gn9i2o', '115.146.90.196', 1516901447, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313434373b),
('acpt4ftb1knvqe36e6vh3sv6b5lk4b5f', '72.51.42.145', 1516998241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383234313b),
('aeuhdblagp5cfcau5b9j6qfo9te7rvhe', '178.73.215.171', 1516845662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363834353636323b),
('ag62s9fh6lo98nhjnvkeklol4naq9q6o', '195.110.34.50', 1516959066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393036363b),
('agrtt5ub5p8cs335dp1hd1jlop7ea9kl', '195.110.34.50', 1517054976, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343937363b),
('ah0cbobfqfe0ep7p6bnf3ko4voutjunr', '195.110.34.50', 1517043939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333933393b),
('ahs8ainq4b79crl7iha462b9rt18r6he', '94.234.38.153', 1516968213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383231333b),
('ak10p3tkefmv2i882nam26jm2kr7cl6n', '105.71.128.223', 1516996650, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363635303b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('aoncjdook51felp4adfmp8dkj0jb3039', '195.110.34.50', 1516995273, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353237333b),
('b4gsm3e1jv7utur9ggtott6se45uoslo', '96.47.226.22', 1517061479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036313437393b),
('b5cefuh1pch4r67n7ehujgmgssimr1rn', '184.217.6.129', 1516984052, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938343035323b),
('b5iajq44sh107g7k23sfrad2d3bpbesi', '184.217.6.129', 1516984012, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938343031323b),
('b6brllp07ju297b6154qlg1lttqcq3h6', '105.71.136.97', 1516910361, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931303336313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34323a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d646576656c6f7065722d313134223b),
('b6flooecjhjm07mokgkl6kqa7mvauhs6', '195.110.34.50', 1517004710, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343731303b),
('b72rg8i1osn9u97ll5olu0jickn1ni3n', '105.71.128.223', 1517000670, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303637303b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('b89vreqkj47kk7opk9icq88tp34285fp', '195.110.34.50', 1516988806, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383830363b),
('b8v9us0f60gluv7f8tkc560cbreks29t', '107.170.230.97', 1516998265, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383236353b),
('b9tiqnk90cc7felcjhlpg90emvkj30di', '41.142.0.106', 1516900261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303236313b636170576f72647c733a353a223950595238223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b6d73677c733a3136343a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e2050726f66696c6520686173206265656e2075706461746564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('bbdunkre8nci4u4g0mol5helk8unsam3', '41.142.0.106', 1516901946, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313934363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b),
('bdn6fq6a1j3vs1suqh3uahto6v56onhj', '195.110.34.50', 1517054461, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343436313b),
('be63miu1n6bq77h34oj0g58ktifeco95', '195.110.34.50', 1517050981, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035303938313b),
('bee3dpno2dhg5rs0vp703nhvcidbnjqn', '195.110.34.50', 1516993302, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333330323b),
('beehrv7hpcibo5afugni9reppbdpeuqk', '195.110.34.50', 1517052969, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323936393b),
('bhojei3jcu15u5qjhac3anqgi155ipin', '190.94.138.4', 1516899708, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393730383b),
('bjeejso91vesbgokgcv0t1a1lmij6iou', '66.249.64.204', 1517001208, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030313230373b),
('bjjdaqji3t331ka2bcdf9g633n0ao5eu', '90.224.199.144', 1516901622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313632323b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231313a30353a3234223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('bkist4pkmbf7o5f4pgp533g6rmgrpk0a', '13.57.20.101', 1517004964, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343936343b),
('bm3c1ntu2vnlbligfsl334oavhrp9l0m', '66.249.66.85', 1517062796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323739353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a35323a226a6f62732f7863762d636f6d70616e792d6a6f62732d696e2d6c617325323076656761732d68722d73706563696c6573742d3135223b),
('bmb7vfd46dtjkpohqqgsm84me88328gl', '66.249.66.85', 1517044607, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034343630373b),
('bo20o3gqkhkt33q6brv94jusuar4ue47', '195.110.34.50', 1517054436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343433363b),
('c3tqhpgsob3cg5ppi2lbq0lsiil499q9', '185.118.27.136', 1517056161, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035363037333b),
('c8ged9aq91e3ci5a2tok2iv29j41tv14', '159.192.221.98', 1517028870, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032383837303b),
('c9p6ch152qldvplp3cjkegvf9g6pboj8', '90.224.199.144', 1516994771, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343737313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a31333a2272616d40676d61696c2e636f6d223b66697273745f6e616d657c733a393a2252616d74616e696969223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('cbb238fhl5dbnovn70oj3ft7qouorucb', '66.249.66.19', 1516873712, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333731323b),
('cefocl208t2j5f252o7lhaa6cdr0japt', '41.143.187.214', 1517048128, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034383132383b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539356236333565223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('cevo0e0rb0ldi0ftvbgku8is8iduq4j5', '83.183.12.57', 1516992092, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323039323b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('cj2aeuuh3o25kdom9h6ff26p6ecjs8t2', '66.249.66.19', 1516903957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333935373b),
('ck0cmg5am32icm07927a9h8mfs2io5tf', '195.110.34.50', 1517001085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030313038353b),
('clscvtrk14qr0h3no6o7hmsfsb9hkqvq', '158.174.4.45', 1516912611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323631313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343234223b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b),
('cmttnc4j9kthnoh1s32btv9mk8mjd22k', '66.249.66.21', 1517040060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034303036303b),
('couk2v0qdd2q1fncbcc0ntvdmnjv3faj', '195.110.34.50', 1517004871, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343837313b),
('cve2ek1sii847d24lejl4icp8dkdfebi', '83.183.12.57', 1516992834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323833343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a32313a2272616d7a6974616e616e6940676d61696c2e636f6d223b66697273745f6e616d657c733a393a2252616d74616e696969223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('d16pkaa3c7pbjmb5pej63be22gp9s7po', '83.185.94.42', 1517060236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303132323b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b),
('d1pvr6ppiduuabtnmdlvchn5vqra31d9', '195.110.34.50', 1517004764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343736343b),
('d2ckuarn9c2c1uqd88rflvq2u5lf1e8v', '66.249.66.22', 1516873621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333632313b),
('d4acptbms5somvts0tsfcenrv4den1e6', '195.110.34.50', 1516989805, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393830353b),
('d4f5elsim1hlqg20f2elue15bn0hu3e5', '83.183.12.57', 1516898700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839383433393b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2258334644223b),
('d636mlfqo74hq588fnpcc2dgsat78iqb', '201.238.154.92', 1516973041, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937333034313b),
('d8u9puq44ach7nofe07dplhvckkvbg1u', '41.142.0.106', 1516899934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393933343b636170576f72647c733a353a225254344e55223b),
('d9gu6dpb5petfsqafknhsk0bh5i6ih8o', '105.71.128.223', 1517011050, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031313035303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32383a22656d706c6f7965722f656469745f706f737465645f6a6f622f313134223b),
('d9m43sgfk3iqeumct88ftj0jppfmj4pp', '91.121.70.58', 1516995737, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353733373b),
('dadcdii4rrv188fooln7h6hehcggi4gi', '66.249.93.77', 1516910474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931303437343b),
('de30aupr76irvsk40akuikt1r76uuq04', '158.174.4.45', 1516917181, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373138313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343234223b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2254394c34223b),
('dedefjnreo5rak76p09i3223rlkvv8l3', '195.110.34.50', 1516988467, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383436373b),
('dida06dket7nlv7oemjq9efu3ma5oaqc', '195.110.34.50', 1517054972, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343937323b),
('dklo2a4kmnrl0he5srfab3c5b0u3fp3s', '105.71.136.97', 1516915412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323930373b636170576f72647c733a353a225538564635223b757365725f69647c693a3231303b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('dkmp2ugi5fi0abjgfudr1thqechd3288', '195.110.34.50', 1516994930, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343933303b),
('dpa9e8tqul88r2ue36pb65e6aqj2qh7m', '66.249.64.204', 1516962933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936323933333b),
('dq5lp4iq3pvleq2igikrd1bcnc6lfamt', '105.71.128.223', 1517004477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343437373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('dq7n575c358907iopmqjqd2cpme85oc4', '66.249.66.19', 1516873428, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333432383b),
('dqsml5lb6545b0abjk4kl7bs6m3bim6k', '105.71.136.97', 1516929067, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363932393033383b),
('durj61ob0fdh6qs8clupskc3s6p0hdpq', '195.110.34.50', 1517054163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343136333b),
('e32014fn8jddb0qa3h51n6ahefv932se', '60.191.38.78', 1516879922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837393932323b),
('e4nj9n83u7qod5csmb1ltrjleuge0a3d', '195.110.34.50', 1516999492, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393439323b),
('e5bojh9kvv9f6qc4cupe4l3led382thl', '41.142.0.106', 1516900739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303733393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b6d73677c733a3136343a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e2050726f66696c6520686173206265656e2075706461746564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('e5dj89jalqkuphn4n04def21rjlctjmb', '94.234.38.153', 1516968202, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383230323b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('e5gd8t6i37vsnsr6a1kf3i51miho83jt', '105.71.128.223', 1516996159, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363135393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('e5pjmbgdinoe0o1alkoihs55ckuthcqr', '195.110.34.50', 1516994708, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343730383b),
('e7e943cu3h7laiguqarmq03e74dijcrg', '66.220.156.57', 1517004996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343939363b637074636f64657c733a343a224e325735223b),
('e8gbl2i4jik0fsmpdjstca8b92j6duim', '66.249.66.19', 1516903967, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333936363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34323a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d646576656c6f7065722d313134223b),
('e9t4l3aq15486c22bgo5ll2r8imc6p0j', '41.142.0.106', 1516896106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363130363b636170576f72647c733a353a224b5a533855223b),
('eac6qkgl8167ubb0gtvfse003k3geuh6', '74.115.214.139', 1516922897, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363932323839373b),
('ebl6ro2jf8deslnvr1jrikqc4d2d478s', '85.225.194.156', 1517049557, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393535373b),
('ed4ffhls78i1dq60666170guk6fj9jcr', '84.219.189.69', 1516990956, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303935363b),
('eh731ii783uk3hiqqtjrtck1gt93sj08', '105.71.128.223', 1517013677, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031333437373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b6d73677c733a3136373a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e3c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e3c7374726f6e673e53756363657373213c2f7374726f6e673e204a6f622041647665727469736520686173206265656e2075706461746564207375636365737366756c6c792e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('ehqmjhh9r34f57qgvcmdtem8eldh8ci3', '185.118.27.136', 1516991174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313137343b),
('eji4t4ep3q7o4jr4ca1rqg6ah8alpa4j', '90.224.199.144', 1516989747, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393734373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a303a22223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b),
('ejveveva7kem5gdoiinqa74d0ipon635', '105.156.230.57', 1516988966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383835393b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a36343a226a6f62732f6d6567612d746563686e6f6c6f676965732d6a6f62732d696e2d6e6577253230796f726b2d7068702d646576656c6f7065722d323f73633d796573223b637074636f64657c733a343a2247374b35223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('em29f1in1a8shpijce2l6k0lgkf9mkoq', '41.143.187.214', 1517044060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034343036303b637074636f64657c733a343a224e325735223b636170576f72647c733a353a225637425151223b),
('eqfhuqg5c3ggop0n4snm4dcuc5dfljee', '185.118.27.136', 1516897970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373934313b636170576f72647c733a353a2238465a4233223b757365725f69647c693a3431313b757365725f656d61696c7c733a32353a2268617373616e61796f7562383540686f746d61696c2e636f6d223b66697273745f6e616d657c733a383a226766676667666868223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('eu6n6s71kdrpgudhq9fsadkq8sh2a7p4', '66.249.64.202', 1516931234, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363933313233343b),
('ev2m7sskjj969mgsk5ba90mhcr4fmpjr', '195.110.34.50', 1517000045, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303034353b),
('evarja0kush5dhe0lo57cgr1evn3p7q8', '66.249.66.136', 1517029911, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032393931313b),
('f0oh0nknl4mb1pd9c4c2dee6vdl3oiu5', '41.143.187.214', 1517045735, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034353733353b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539356236333565223b75736572656d61696c7c733a303a22223b),
('f5k3fg71us356rect1h7t9aog6kd0680', '66.249.64.200', 1516940784, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303738343b),
('f6j9tm1puk19tvmg4t8pu8olbhdvu7vp', '66.249.64.204', 1516949422, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934393432323b),
('ff5p2lvibs78lmnlqehvgl8fqsfpqsed', '41.143.187.214', 1517045382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034353338323b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32323a2263616e6469646174652f376336363539356236333565223b75736572656d61696c7c733a303a22223b),
('fft05ur93sql7tq22p4mnt7vmsr7d55q', '195.110.34.50', 1516991542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313534323b),
('ffu85eii01vpfjeccelk8nmlj2eich23', '195.110.34.50', 1516993881, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333838313b),
('fhv611usutkai2q9gcc7i206jpabdf1g', '105.71.128.223', 1517012822, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031323832323b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('fila9l3don5hl2qrjibsgo859b789s2j', '195.110.34.50', 1516991383, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313338333b),
('fj7prff0aprotndg4nma4r9vvhlq7jcv', '185.118.27.136', 1517002553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030323535333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('fmksj1qtai4fs2nbic2gsk8fb5e0b6dm', '195.110.34.50', 1516994809, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343830393b),
('fpiq6h609e9eq636apn44pg6hu7bpm2b', '105.71.136.97', 1516911550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931313535303b636170576f72647c733a353a225538564635223b757365725f69647c693a3231303b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b),
('fsb1avv64l3hsgpofrfja4jo5pmbgkqo', '195.110.34.50', 1517044061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034343036313b),
('g4qu1jseh82ggqij0dhj3a9rn8eopq61', '90.224.199.144', 1516991383, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313338333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a2250535a5a42223b),
('g6c7p5ccc8c5jmmm2bmfluhev8fmohdm', '85.225.194.156', 1517049584, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393536303b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('g81aibq0ee3susolgmj8lhak20qne716', '66.249.66.21', 1517010441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303434313b),
('g9m1rf3bu7suvnh2l36odt4joshk83qi', '66.249.64.200', 1516923441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363932333434313b),
('ggofc7glp9a5jdlc5hkfqrckiq31sk2b', '195.110.34.50', 1517004760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343736303b),
('gh3kuv945sv64j1omh35irt0miscclp3', '90.224.199.144', 1516993970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333937303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2247374b35223b),
('gm608sevhg70s7altc4ba2m3ckp26qof', '195.110.34.50', 1516993949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333934393b),
('gn2ft52uu9uippjs8nv32ac254lulcdj', '66.249.64.204', 1517000980, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303938303b),
('gor1dgu7n8hfq8j3kl3rse2ckv66jvgp', '108.171.101.195', 1517049276, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393237363b),
('gtnahggo8ss2c75rgdjmh5qlutcml6gq', '66.249.64.204', 1516940331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303333313b),
('guusa9865gdfh4l1596jlvgg527nclgi', '158.174.4.45', 1516912980, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323938303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343234223b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b),
('gvaeu86le5jqf2jqpnoet56qc7dnb715', '190.94.140.88', 1517062569, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323536393b),
('h05nh885dil9df4ddunjb019dls8c697', '164.132.91.3', 1517006800, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030363830303b),
('h40e3oc6nnms2rvqt4lv3b9a85ne7teg', '66.249.64.200', 1516917593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373539333b),
('h4ngsq65l4rfs7envdmmnlt011pjmjbk', '66.249.64.204', 1516963063, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936333036333b),
('h4og41i6718va4bli1v567gf58d6nheo', '66.249.64.202', 1516940744, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303734343b),
('h59a2fv2piheot4s7ikdu4o0tal9qqi0', '195.110.34.50', 1517054279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343237393b),
('h5f8gc1tq2biip34pc9o2uf3n1ants9f', '66.249.66.19', 1516873550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333535303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31363a2263616e6469646174652f346433653261223b6d73677c733a35373a22506c65617365206c6f67696e206173206120656d706c6f79657220746f2076696577207468652063616e6469646174652070726f66696c652e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('h7rm2jjuql515jtm76lq2tq5skn9du34', '66.249.64.204', 1517000810, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303831303b),
('haeun93oocgfocmqnumfbvqtb73flv30', '139.162.114.70', 1516995104, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353130343b),
('hb5std40b04cn2o5pflnhmaascfaliqh', '54.183.159.85', 1517004963, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343936333b),
('hd58g1b426m7jt250gnd9s05iv1di57u', '185.118.27.136', 1516997787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373738373b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('hega2la1ocgk9gg0kkc91plhtoet3676', '105.71.136.97', 1516909711, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930393731313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a34323a226a6f62732f6269786d612d6a6f62732d696e2d73746f636b686f6c6d2d646576656c6f7065722d313134223b),
('hfhi1tn5i6315f15nq5cku7q048la83q', '41.143.187.214', 1517057182, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035373132353b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('hfjehkisl5jklke49jc3aumvarlc0pmh', '105.71.6.188', 1516833790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363833333539333b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2242345738223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223350474837223b),
('hfo64bcs3g8j9hge9jhgb1jr180h2tjn', '173.252.123.128', 1517005197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353139363b637074636f64657c733a343a2254394c34223b),
('hg7mdifhu9csp222oqtk3087rd96plbn', '54.215.214.95', 1517004963, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343936333b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('hh5cf0f1fns4khpu0rhu7h0q1d40m882', '90.224.199.144', 1516900477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303437373b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b637074636f64657c733a343a2247374b35223b),
('hhfn89n9docp56oja63q8efnduua9ss9', '66.249.66.21', 1516876670, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837363637303b),
('hl2o14sdrgcniog8jbp88f528em0i5r0', '195.110.34.50', 1516991613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313631333b),
('ho1i2us181mv9anq608cs966kbc74l30', '105.71.128.223', 1517013160, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031333136303b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('hu0mmh6vnqhmno8gcftk1ajs2n95oj5l', '184.217.6.129', 1516984086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938343038363b),
('hucl6bkmf9l3o3sobbrjanr67aq2qbsh', '195.110.34.50', 1517054451, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343435313b),
('i0i620ek3uhudm91m8oukbeetnb2vog6', '90.224.199.144', 1516993512, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333531323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a31333a2272616d40676d61696c2e636f6d223b66697273745f6e616d657c733a393a2252616d74616e696969223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('i1od33dq4mo8caedfirg8lcat8kfotfq', '2.65.17.62', 1517062201, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323230313b757365725f69647c733a333a22323133223b757365725f656d61696c7c733a32313a226c6962616e6573656e40686f746d61696c2e636f6d223b66697273745f6e616d657c733a32333a224ac3b66e6bc3b670696e67732074696e677372c3a47474223b736c75677c733a31373a226a6e6b70696e67732d74696e6773727474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('i1quubn7udunl158ofdiidgvpbj5mv45', '195.110.34.50', 1517055003, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353030333b),
('i27qksh4bmefhqo82amkhlsktcu5rklb', '185.118.27.136', 1516895105, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839353130353b636170576f72647c733a353a2235384c4a43223b),
('i2ujpg1nkgjb8cbhfqkhq0j46ecsd50r', '108.171.101.195', 1517049266, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393236363b),
('i3a8q3abna5sjm50565s47b567olfe33', '90.224.199.144', 1516996958, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363934393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('i4dq27b9erv9ld4n19qensoaboa81e27', '158.174.4.45', 1516915839, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931353833393b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a373a2265676f2d646576223b637074636f64657c733a343a224e325735223b),
('i56inu1qghdejr6957d8mt2f3n59rfck', '195.110.34.50', 1516988481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383438313b),
('i596au4d8qi7j83pj3hurv0aqadmm3bj', '195.110.34.50', 1517005186, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353138363b),
('i97qh1nclr5l19hn49lej26c9hj3se2h', '66.249.93.77', 1517054260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343231353b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b),
('iarjnuniaiup0k3sbeo6ssoqrrlcbgm5', '74.115.214.149', 1516881768, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363838313736383b),
('iau3vnvkn7uee2crh99c84cs13nj6tof', '41.143.187.214', 1517052645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323634353b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('ibn3ugbbis5fa830ibt1euq6rk1775vi', '195.110.34.50', 1516993322, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333332323b),
('ickota65d0jgbcfdbai2eia9sttsnj4a', '105.71.128.223', 1516995832, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353833323b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('ifjlov0g1al7hefrusodtsg4p8a155f3', '41.142.0.106', 1516895475, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839353437353b),
('ig7k07f4hf0a04f6vdp35vr20qg4upe4', '41.143.187.214', 1517053685, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035333638353b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('iginuq3kqahh9sc8mdb4pa20uolftdpd', '158.174.4.45', 1516917494, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373439343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343234223b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b),
('ih976r6htfe6kql7083hehicpond31c2', '90.224.199.144', 1516997046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373034363b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('iha2fknj1utdro9csadq7gir7qcr2ura', '195.110.34.50', 1516995308, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353330383b),
('ik8dohvsdt14b9cjg2q2f426cevm4i3v', '94.234.38.153', 1516968213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383231333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('ikvktvr0ihqj4qteq01a0le55kfuui51', '66.249.64.200', 1516983883, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938333838333b),
('ilfjnj6odhd42rkrep8dv108ia11s8if', '85.225.194.156', 1516981373, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313337333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2254394c34223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31373a2261646d696e2f6a6f625f7365656b657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('imosauaqm8a5qo15uutnijfk28lflc2n', '90.224.199.144', 1516995513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353531333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2254394c34223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('iorrfv0bjdjqfd4k0t4ldk4dnjgjj42f', '105.71.136.97', 1516912978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323936363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b757365725f69647c693a3432343b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223252465634223b6c6173745f6e616d657c733a303a22223b),
('iq295i63ntvo3q8mrulblsajsmof78c8', '41.143.187.214', 1517048161, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034383136313b),
('itrbi6jge8v4nmu2ef22gs940v84k2j4', '185.118.27.136', 1517059987, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035393938373b),
('j0f1hktughmu6gio2nsqo4povp53qu68', '69.63.185.121', 1517054279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343237393b637074636f64657c733a343a2258334644223b),
('j45nkkvrvdkprk110n5701gm235nom43', '190.94.140.88', 1517062582, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323538323b),
('j5md68u5lilfgtj2qs4j7b3uba9uh89b', '90.224.199.144', 1516897884, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373838343b757365725f69647c733a303a22223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b),
('j996lmfbp25ju4ns8k7uc02ogot5ok02', '105.156.230.57', 1516960683, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936303638333b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2258334644223b),
('j9t686k7tqjc55q4p7d6q6bgoobv9iai', '105.156.230.57', 1516968050, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383035303b757365725f69647c733a303a22223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b636170576f72647c733a353a2259524a4735223b),
('jaru36dlh7bol3i856vvft0l3112ue87', '66.249.66.21', 1516873466, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333436363b),
('jdtklsve293i37itdgk4efcrngjgb0jk', '41.142.0.106', 1516895785, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839353738353b636170576f72647c733a353a224c4a315657223b),
('jemdvnp1clmvh2d9t6tgca1447i42af6', '195.110.34.50', 1517054260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343236303b),
('jgc2ftr4dm6dhjh14cunuujiqdcb5vu9', '66.249.64.202', 1516992977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323937373b),
('jh9gvlh3cqk5t6n8ia7vunng3g7ob54d', '195.110.34.50', 1516959087, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393038373b),
('jhcj1qkuruv93budacl5oa6is57bebkm', '90.224.199.144', 1516990372, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303337323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a2250535a5a42223b),
('jikdiou0ak94n4835lfj9abqpjcoeos2', '2.65.17.62', 1517062201, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036323230313b757365725f69647c733a333a22323133223b757365725f656d61696c7c733a32313a226c6962616e6573656e40686f746d61696c2e636f6d223b66697273745f6e616d657c733a32333a224ac3b66e6bc3b670696e67732074696e677372c3a47474223b736c75677c733a31373a226a6e6b70696e67732d74696e6773727474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('jir47pamumo0275netc1khisb7qj2c24', '66.249.64.200', 1516940627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303632373b),
('jm4usbmn31tbe5viuksdi29pchad2u2p', '90.224.199.144', 1516899994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393939343b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b637074636f64657c733a343a2247374b35223b),
('jnm0frk3kl6eibj4g3ohrhl64f4oaimt', '185.118.27.136', 1516996892, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363839323b636170576f72647c733a353a223952444d48223b),
('jpblfv4if7r10f41n3vpktd5f0v7tfes', '66.249.64.204', 1516984059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938343035393b),
('jq7os9c062ikth8f9q9vtgr9oii40gf2', '83.185.94.42', 1517059695, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035393639353b),
('jqco0pikars8061rtarv2vgogh2f7do7', '66.249.64.202', 1516922140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363932323134303b),
('ju9fmcskbds0ghta0e8cr6dgfolk01lo', '105.71.128.223', 1517000260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303236303b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('jvis6frm9hdfgu14p253mbv3mb7c2hks', '158.174.4.45', 1516916576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931363537363b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a373a2265676f2d646576223b637074636f64657c733a343a2247374b35223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31373a226a6f627365656b65722f6d795f6a6f6273223b),
('jvvo565tggr03g2dhc4uhacn0t9lm9j9', '83.183.12.57', 1516993141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333134313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323136223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a31373a224d616c6dc3b62054696e677372c3a47474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b7570646174655f616374696f6e7c623a313b5f5f63695f766172737c613a313a7b733a31333a227570646174655f616374696f6e223b733a333a226f6c64223b7d),
('k4hseuq7mfm1mnebs0g7nv0jp7hq7lmn', '66.249.64.204', 1516944875, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934343837353b),
('k688ua3nqf3jbasv7fm558of1j42mo7r', '41.143.187.214', 1517050719, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035303731393b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f63765f6d616e61676572223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('k6u1nqld3v88qi53s2a30j2e9gcnijfu', '41.143.187.214', 1517047921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373932313b),
('k7lu1e3p3md9n93mpb8j7b4v2ov2qagc', '195.110.34.50', 1516995640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353634303b),
('k9kvv8fqqk15ti9lhj0ak8rcnvb18adr', '90.224.199.144', 1516989803, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393830333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b),
('kaav6omhkpom7od1av26l0t45qqqjila', '90.224.199.144', 1516898768, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839383736383b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b),
('kb4mb3imm7i5l4pqci6ddiesj8jn5bjr', '105.156.230.57', 1516959433, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393433333b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2242345738223b),
('kb6bp8it149ukirc3gv9otvsep2irbop', '195.110.34.50', 1517043848, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333834383b),
('kbcutng7buenehm4fspgp1njvd51i4aq', '74.115.214.148', 1517057428, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035373432383b),
('kbndfn63e14vum05bd7tvuvo9dus10j3', '105.71.128.223', 1517002877, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030323837373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('kdcqeo4mobmb8scq20287f1k3qa79g5e', '41.143.187.214', 1517047421, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373432313b),
('kehvm97p8svdd53aeim495aeleqfb79r', '90.224.199.144', 1516996603, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363630333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('kij03nb91vk00sl9u6r7nmfihdaf7pt2', '158.174.4.45', 1516917709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373439343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a303a22223b6e616d657c733a303a22223b69735f61646d696e5f6c6f67696e7c623a303b757365725f69647c733a303a22223b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('kivh38rhgoeu0mikohau0qkg7063hj79', '41.143.187.214', 1517053248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035333234383b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('kj2i5f8p5ncd2ddk2r7sf4jvl1re199o', '184.217.6.129', 1516984066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938343036363b),
('kpr9du07h7qd5ve42dj9c9dplmun03f3', '195.110.34.50', 1517055040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035353034303b),
('kq3p6ajho271j9urj0ad1anapbiu9g7e', '66.249.64.204', 1516967610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936373631303b),
('ks8mn8cl2datfcq04ig9oli9dcg69817', '195.110.34.50', 1517004544, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343534343b),
('ks9l2m2ubokcmkh90ri1ma83b8bp16n8', '105.156.230.57', 1516960118, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393833393b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('ktm7abc5dm33g4k9jlb07l7e9il1itaj', '94.234.38.153', 1516968224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383232343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('kue5rto1ua7a5e82vsnqhvik8kokbd8r', '195.110.34.50', 1516997019, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373031393b),
('kvu7t07qt2lnigqoc1l9tjg34blvso8l', '90.224.199.144', 1516988922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383932323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353934363566336434393466223b6d73677c733a35373a22506c65617365206c6f67696e206173206120656d706c6f79657220746f2076696577207468652063616e6469646174652070726f66696c652e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d),
('l07sm1apujm2hfo97tkd3dhqcb9bg2c8', '190.94.136.235', 1517023671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032333637313b),
('l3er0jbobql8hkg7i504o94ep0c6iuac', '90.224.199.144', 1516992342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323334323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c693a3432363b757365725f656d61696c7c733a32313a2272616d7a6974616e616e6940676d61696c2e636f6d223b66697273745f6e616d657c733a363a2252616d74616e223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('l4b2bcd8h81pr3h43l3o06h7jr4981g9', '105.71.128.223', 1516999872, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393837323b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('l9jjf4p7agdbiit97bcc1nmhnrfa540q', '54.183.159.85', 1517004964, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343936343b),
('lblqbmrl9gt0rqbmhor5nj6hj5acnfef', '94.234.38.153', 1516968223, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383232333b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('lcsovbrl9it5bnivf8e96b60og60jibe', '66.249.66.21', 1516873649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333634393b),
('le864m8kfhnerv6ej44s7nicfdbek7t4', '66.249.64.204', 1516940666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303636363b),
('letogr5shcuv8lgrv216qp1atab1m4us', '195.110.34.50', 1516980986, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938303938363b),
('lifsn434ma7pa6i76i52tnpub20p6on4', '105.71.128.223', 1517010404, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303430343b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('ljo9fd889sm60adpvac4j595ebkouc2l', '195.110.34.50', 1517004823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343832333b),
('lldvknb0ng39quflh6tlfe4gi4egj3it', '94.234.38.153', 1516968246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383234363b),
('lrir0avfnushuamur3j9g165v1n73o02', '195.110.34.50', 1516996751, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363735313b),
('lsu7fto9sf6t4tae739q0mumunhjjpe1', '105.71.128.223', 1516998004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383030343b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2247374b35223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b),
('ltf69mpe5ifo2s1imsplql4va35hnl38', '41.142.0.106', 1516901226, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313232363b636170576f72647c733a353a223950595238223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b6d73677c733a3136343a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e2050726f66696c6520686173206265656e2075706461746564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('lu49cg3deud1me7mr9g89opf85o4cbl5', '195.110.34.50', 1517043849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333834393b),
('lvf2bf09qoo7hhj5ah5t2hfk0js3iokv', '195.110.34.50', 1517000518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303531383b),
('lvj06q0jculvci7t1q969kfvsoub53pl', '41.143.187.214', 1517045054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034353035343b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b),
('m0to2fm1pa622crlokplc643m47ek9qg', '66.249.64.202', 1516972157, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937323135373b),
('m5flakpmqh6rd186msajgk9cm4o02h27', '195.110.34.50', 1517054435, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343433353b),
('mak1mt3hl8abihd0c8c9onvs0i33gvt1', '195.110.34.50', 1517054443, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343434333b),
('maqglse7dkjfl306qi5t69oiccegcdmh', '105.71.136.97', 1516912966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323936363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b757365725f69647c693a3432343b757365725f656d61696c7c733a31393a226133376b696c6c657240676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223252465634223b6c6173745f6e616d657c733a303a22223b6d73677c733a3136343a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e2050726f66696c6520686173206265656e2075706461746564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('mbupmoaki2pqe1n0j5s8tp88g80cfpt1', '195.110.34.50', 1516998410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383431303b),
('mcllu14us99e5mq5bsvvn2seov6g30l7', '195.110.34.50', 1516990674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303637343b),
('mcnh4eltppm2tgraemb6cd8t5t5pk4ik', '195.110.34.50', 1517043849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333834393b),
('md8o0n9qgvf2bch4sq1f2eufvgm74vqn', '195.110.34.50', 1516994408, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343430383b),
('mdboeb03rv8p5g3r2ubi6bfm7duncis5', '195.110.34.50', 1517060171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303137313b),
('mhso8j1fkea4842qiugv8f649vvn5ccs', '41.143.187.214', 1517047791, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373739313b),
('miefog1tfhudrp8o1ps7rs0ah3rsnk7q', '66.249.66.21', 1516873510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333531303b),
('mjci5vg6h04ujgg1n10co60nqr5er55i', '185.118.27.136', 1516998476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383437313b636170576f72647c733a353a223952444d48223b637074636f64657c733a343a224e325735223b757365725f69647c733a313a2239223b757365725f656d61696c7c733a31343a22717765727440746573742e636f6d223b66697273745f6e616d657c733a31303a224d696368656c204a656e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('mq21ljte27mqf15n1tsja49pggqfo3mg', '83.183.12.57', 1516995425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353432353b),
('mq73a52p0j9vpljtpr674bpijd9rn7qe', '211.100.7.133', 1516966782, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936363738323b),
('mqjdiam2q7ji90up413e0dtesein4l6j', '195.110.34.50', 1516996657, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363635373b),
('mqoh1ms166bbhq9vsbvou8g8dsfets2h', '66.249.66.157', 1516899405, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393430353b),
('ms7a3vpe6s9nu4vfq7i6ft636pnh7bdo', '90.224.199.144', 1516992693, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323639333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c693a3432363b757365725f656d61696c7c733a32313a2272616d7a6974616e616e6940676d61696c2e636f6d223b66697273745f6e616d657c733a363a2252616d74616e223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('mu4fe1kb0b0kkn9vinvs9s24fivdstv4', '90.224.199.144', 1516897575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373537353b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a2237384a4c52223b),
('mu904ahtqnfc712m2nujn9o5qjhj8la4', '85.225.194.156', 1516981410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313431303b636170576f72647c733a353a224a4e314459223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31343a226a6f627365656b65722f63686174223b),
('mvb0pe1djnf9idt0ejt6bs474el129ns', '54.183.159.85', 1517004977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343937373b637074636f64657c733a343a2258334644223b),
('n5eqhhg37mep694pdt57vfvma7rd5ic2', '94.234.38.153', 1516968224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383232343b),
('n5fqk4e6pk4241lv2jkv1jkrsbmdp3na', '90.224.199.144', 1516989439, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393433393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b),
('n71m24g599pltg5mvv4n8p6nritgtga5', '105.156.230.57', 1516959027, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393032373b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('n83k3gab4l1kcseb5pdq2dqo6jfea3vh', '195.110.34.50', 1516999260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393236303b),
('n8l7g8e0ff36iabib0nr6sab9vqigsp8', '90.224.199.144', 1516902812, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930323831323b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231313a30353a3234223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b6d73677c733a3136383a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e20596f7572206564756374696f6e20686173206265656e206164646564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('na0chpcbf9i3hdco8pnripj8l5s4t79m', '41.142.0.106', 1516896548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363338343b636170576f72647c733a353a224e50445844223b757365725f69647c733a303a22223b757365725f656d61696c7c733a353a226140612e61223b66697273745f6e616d657c733a313a2261223b736c75677c733a303a22223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f6164645f736b696c6c73223b),
('naaljv0jlub2p57fajh0h10j7i0cgt12', '90.224.199.144', 1516997046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373034363b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('nemae6m77q4ioo8au2a789asouoputcs', '195.110.34.50', 1517054725, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343732353b),
('nfrhctc0kiiq3fa3jv4md77iicm0o9vp', '66.249.66.22', 1516873511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333531313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31363a2263616e6469646174652f363735303231223b6d73677c733a35373a22506c65617365206c6f67696e206173206120656d706c6f79657220746f2076696577207468652063616e6469646174652070726f66696c652e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('nfvuef1uupe43v4pdilcdgb85r0mbear', '90.224.199.144', 1516897782, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373738323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f6164645f736b696c6c73223b),
('nghbn6giu93n982ophutn6gr4qtgenpv', '66.249.66.19', 1517035513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373033353531333b),
('nhfmfg4imgllg49627gcq9jb8tkklrea', '66.249.64.202', 1517004364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343336343b),
('ni5phc8h8v7e2hvllu953fqf4jcs8hj1', '169.60.28.112', 1517054496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439363b637074636f64657c733a343a2242345738223b),
('nke7bibc3mie1vat76rrkm4e7i1bio1i', '195.110.34.50', 1517004489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343438393b),
('npqqiratm5nccm85ij89jnfoo3luqjsm', '41.142.0.106', 1516900929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303733393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b),
('nqgejckok9gvccd9mnopavs7qf9plj2j', '83.183.12.57', 1516995021, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353032313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a224e325735223b),
('nsu62rbc583i3hr3hdn6cj4sq9br33dq', '90.224.199.144', 1516996606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363630363b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2242345738223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('ntd4i90apu33itf65mugb71nt19a05s4', '159.192.221.98', 1517028883, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032383838333b),
('o1rse3q98st18hnq13un9dnbsgju7a9r', '66.249.64.204', 1516913046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931333034363b),
('o2ahv1pah0ilp21rdcmr41ap2989mlrs', '195.110.34.50', 1516988409, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383430393b),
('o4o9sd3psa9i5c7vei11itjm247gnj24', '195.110.34.50', 1517004480, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343438303b),
('o91m2p0n5atslbsod3ie1pm2akqn3mac', '105.156.230.57', 1516967749, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936373734393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('o9a18ljk7gk5ccgbrn8ni124ma8dlh2t', '195.110.34.50', 1516995539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353533393b),
('o9jqhfomgfg98c686idejv72kautqlet', '195.110.34.50', 1517054498, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439383b),
('ocj1snh00k6fkdagf1t8monfnvs627t2', '105.71.128.223', 1516999567, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393536373b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('oguc1scbifnm4jvie316lvsks9ua0q45', '195.110.34.50', 1516994246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343234363b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('onq1sj0q95vgl0lu466deuuf4d7oe0uq', '41.143.187.214', 1517048753, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034383735333b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('orthn011edtscdkpc4bn7lrc88ngjong', '66.249.66.86', 1517049187, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393138373b),
('ouosnbj9ua2f9694eh4s57vmo1c44jqj', '185.118.27.136', 1516993546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333534363b636170576f72647c733a353a223952444d48223b),
('ov72mif9utpguhkvlu56tlgd3cp60frm', '195.110.34.50', 1516994585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343538353b),
('ovocs70pjjl8859u3j6ptjh2gsvhjcc5', '195.110.34.50', 1516990435, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303433353b),
('p0v95857m0mus3hf0ps5ktu7pd3akctn', '195.110.34.50', 1516997712, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373731323b),
('p1p6c1eku7rtd3nt7dl583ua1d4ranko', '54.215.214.95', 1517004942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343934323b),
('p2t7n6g3ejqs1q371ct5cj9g9aa1dhf5', '105.71.128.223', 1517001066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030313036363b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('p30ich69rf4jhulj3h6duh55epn1a974', '41.143.187.214', 1517050141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035303134313b),
('p3219muld4fb4kbq0okld51bjq4adn6r', '185.118.27.136', 1517002553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030323535333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('p426sfjcdi5u43vmq7b00ih725e23fvb', '41.143.187.214', 1517054972, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343937323b637074636f64657c733a343a2254394c34223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('p461meksctm9jlggp4i78t8j31hmgk8p', '90.224.199.144', 1516993859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333835393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a31333a2272616d40676d61696c2e636f6d223b66697273745f6e616d657c733a393a2252616d74616e696969223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('p588epvqsjiqpmmcokp375j9at8enmrq', '66.249.64.200', 1517001136, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030313133353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32313a22656d706c6f7965722f706f73745f6e65775f6a6f62223b),
('p5n9bdnuo9pp01441qc538cpfbj8j7qv', '195.110.34.50', 1516990026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303032363b),
('p8ubrf6ens4e7cr4pggpu6a3rsurs1r9', '105.71.136.97', 1516912907, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323930373b636170576f72647c733a353a225538564635223b757365725f69647c693a3231303b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('p960obeeob6ifs525rcsrl17v90ag87o', '90.224.199.144', 1516990428, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303432383b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2242345738223b),
('pbpcaop4210jthe675hrdt525b7qqkn2', '66.249.66.21', 1516873593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333539333b),
('pee7bdmt61477v95u6ehtjstqalc6cn5', '195.110.34.50', 1517054975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343937353b),
('pfef48kfcrnh6smm1cn55s9b4lvdciib', '41.142.0.106', 1516901235, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313232363b636170576f72647c733a353a223950595238223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b6d73677c733a3136343a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e203c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e203c7374726f6e673e53756363657373213c2f7374726f6e673e2050726f66696c6520686173206265656e2075706461746564207375636365737366756c6c792e203c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('pff1v5f37t9f3a3vvn60qfi45g3hbbno', '41.142.0.106', 1516899428, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839393432383b),
('pgh3mqsrt6cuiq5ud8cjdn8m06hlfib1', '195.110.34.50', 1516999514, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393531343b),
('pgiak46kh2qp0pgt3p86e0dnnvqvp56e', '195.110.34.50', 1516961263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936313236333b),
('pgimc8l9no29p9mnaeq86o94gbv10j2v', '195.110.34.50', 1516995513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353531333b),
('pij00dms4pnticd1paseu9crgt27qscd', '90.224.199.144', 1516991082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313038323b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a2250535a5a42223b),
('pjr5a5d9cls8gs5l8bcc90omhm9j6bsu', '83.183.12.57', 1516995770, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353737303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a353a226269786d61223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224254364a51223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a224e325735223b),
('pknnmeek6udmj11tc0bjp5o9cvuaev14', '195.110.34.50', 1516996681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363638313b),
('plccp4hpqeu6k74laa6o54t5rutg17va', '41.142.0.106', 1516900413, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303431333b),
('pli60eoogi0877kcf509jsfecaelb8ls', '41.143.187.214', 1517054484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343438343b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('pnud3n8205lmnhpvp5dv002ai2hrtgqj', '158.174.4.45', 1516917561, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373536313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a393a22747261766f732d6162223b637074636f64657c733a343a2242345738223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b),
('pp2i9o3og82ck4rl8hfa0abge3a9j8f4', '66.249.66.22', 1516873565, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333536353b636170576f72647c733a353a223754353453223b),
('pp8gr79mrdck36e9s3itmocvldpffanc', '195.110.34.50', 1517004780, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343738303b),
('pph7r6vc6ru0bnvc8tv32cddns3dck79', '66.249.64.204', 1516976705, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937363730343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a2263616e6469646174652f37633636353936323539223b6d73677c733a35373a22506c65617365206c6f67696e206173206120656d706c6f79657220746f2076696577207468652063616e6469646174652070726f66696c652e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('pt5egojoshhobjukqebqa8nrnavpkfn0', '66.249.66.157', 1516894858, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839343835383b),
('q1eifjt6a9imqtphq2g47rs2jnthghj6', '66.249.64.200', 1516935781, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363933353738313b),
('q2fcv3fpkiu0f3hrduo6ta4qerjvmhnl', '195.110.34.50', 1517043837, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333833373b),
('q422qev1ju1656pl7ib8rehjhhcmeg6g', '41.143.171.45', 1517063203, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036333230333b),
('q62npje98jrg4qdc818u2n3ct7tjl71p', '195.110.34.50', 1517043940, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333934303b),
('q7k8tlsr3nogj5jkjko46n8gi7j37naq', '195.110.34.50', 1517043866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333836363b),
('q8be0p1otjlffb5gvr7e0970lj9lid5k', '80.110.31.2', 1517033278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373033333237383b),
('q8i3rlj793qf1drj4rembhak4a3hetmn', '105.71.128.223', 1516998679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383637393b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b7570646174655f616374696f6e7c623a313b5f5f63695f766172737c613a313a7b733a31333a227570646174655f616374696f6e223b733a333a226f6c64223b7d),
('qabma71c5spbli35risoh1q1h8oj562v', '85.225.194.156', 1516981462, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313337333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31373a2261646d696e2f6a6f625f7365656b657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('qbe1vjunclv0vl5b5sd90k8rj5dvd8ns', '185.118.27.136', 1516991166, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313136363b),
('qfgslegldqe26htbqm0010q1pj0udfr2', '195.110.34.50', 1516988474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383437343b),
('qfprss9t49sg9i770kr35silsp581pco', '195.110.34.50', 1516981098, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313039383b),
('qgh8a9d4gu5ss6inf9mlhnuoof7okuvb', '195.110.34.50', 1517000670, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303637303b),
('qh0vnphnfb7jkuem1piuj1qg4v0jqvfu', '195.110.34.50', 1517043847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333834373b),
('qjc4imh6uv4vn9angjke6b5ggucl4fhq', '41.142.0.106', 1516901599, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313539393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b),
('qlaik7ff6qh3cidr4qbmf38v720pgrc0', '83.183.12.57', 1516995492, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353432353b),
('qmlucsha5rjcc5mnvo7b8c4j8pgpbj0b', '195.110.34.50', 1517054436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343433363b),
('qnhc61kr77f5c0f4ilvabmago5fvb93o', '90.224.199.144', 1516994177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343137373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a31333a2272616d40676d61696c2e636f6d223b66697273745f6e616d657c733a393a2252616d74616e696969223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('qohh4tj2ib5k9ofl98hcc5a49qousitp', '66.249.66.19', 1516873431, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333433313b),
('qp8avge3ttjtnsrcjf3fdicqlf6ch5uf', '83.183.12.57', 1516994193, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343139333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323136223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a31373a224d616c6dc3b62054696e677372c3a47474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31343a226a6f627365656b65722f63686174223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('qpbacin631j3p07ne3ooscbcmv4mfjtn', '41.143.187.214', 1517047932, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373933323b),
('qput99qpoj3349j8cghnsae1ps0fptf9', '195.110.34.50', 1516999603, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393630333b),
('qrfsjf2dldmv34i6mcv8jum6qhpes572', '158.174.4.45', 1516916299, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931363239393b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('qrhl425jpo0d8vpbaten8tev658q4bi1', '105.156.230.57', 1516966434, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936363433343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31313a2261646d696e2f7061676573223b),
('qu3a89q44u6dcljp0lvqs270jos6od11', '195.110.34.50', 1517001345, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030313334353b),
('r0bfbskdj0f07v5ktochb0rl5gqrlf21', '66.249.64.204', 1516940825, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303832353b),
('r0ikp1rakjg8fmql2lfvjqg0uihenvoj', '66.249.64.200', 1516940872, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303837323b),
('r0op1hm5lo4dt7jnodn3gqrd7u728se5', '90.224.199.144', 1516991411, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313431313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('r167b78tf1o3724no62l93jgedi1sfen', '185.118.27.136', 1516998471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939383437313b636170576f72647c733a353a223952444d48223b637074636f64657c733a343a224e325735223b757365725f69647c733a313a2239223b757365725f656d61696c7c733a31343a22717765727440746573742e636f6d223b66697273745f6e616d657c733a31303a224d696368656c204a656e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('r434qkvf9fu176hmmpjt4fdfk8nptp6e', '90.224.199.144', 1516988922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938383932323b),
('r633bmk4ngeg9ofuo5j2gc9vvbgpn5t8', '90.224.199.144', 1516991180, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939313138303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2242345738223b),
('ran0jdtcdlcl958pj57v2n20rekv3d32', '41.142.0.106', 1516894609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839343630393b),
('rg4lb5u8tsubbjkepvfr48591ckjgk9h', '195.110.34.50', 1517004868, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343836383b),
('rid6h8qa9asc7t50gm6v2lq9i3rokbj5', '195.110.34.50', 1516989602, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393630323b),
('rj8pdej1bn8u6528g472uj0m2dakql6i', '84.219.189.69', 1516990956, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303935363b),
('rjmj4fndnlg6p66mftt1kgboh0b7saaa', '105.156.230.57', 1516960367, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936303336373b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2258334644223b),
('rk5dlh9kf7s9vjf5kbi8depdd14ps6hu', '190.94.136.235', 1517023616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032333631353b),
('roetgomn40dlhl25arhjh7m2hd7roc27', '54.82.199.232', 1517054499, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439393b637074636f64657c733a343a224e325735223b),
('rqpccevrg7hf7jtvebu7112914la2276', '82.221.105.6', 1516954265, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935343236353b),
('rrgotvbkmrkm8dicjqkuvcvls45ilo4v', '105.71.128.223', 1517004780, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343738303b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2254394c34223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a223247315157223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('rt8c027uhnq41rpgc11vt01ehidg0l0t', '83.183.12.57', 1516990431, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939303433313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a31343a22696e666f40747261766f732e7365223b66697273745f6e616d657c733a31383a22417474756e64612054696e677372c3a47474223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224e33414e47223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2258334644223b),
('s1nlmjcpq00n1s6jlrl34jk6gqnrh5fm', '90.224.199.144', 1516996949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363934393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('s4ju13q367n8lar50dvnahnopg9a73pd', '195.110.34.50', 1516999668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393636383b),
('s4rh4q789ma6ejkbimcg24jd223eegq0', '195.110.34.50', 1517054484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343438343b),
('s5sibk778p88bblre46s1963pajrkf31', '105.156.230.57', 1516967320, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936373332303b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('satq9mvm7vesgglvta1n87scr7rg3eh0', '105.71.128.223', 1516997197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939373139373b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a224e325735223b75736572656d61696c7c733a303a22223b),
('sc5oirud18insnta957vf7q3vct8nhp2', '195.110.34.50', 1516999739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393733393b),
('scootchlg77rmpckasb3n90jn3lg2jd8', '83.183.12.57', 1516992524, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323532343b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323136223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a31373a224d616c6dc3b62054696e677372c3a47474223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a224d334e3851223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a224e325735223b),
('sgar6d8gavo1m4vvkgru4palqbg9g11e', '195.110.34.50', 1517005022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353032323b),
('shdj00tv4iieec7igo0q9ik6n02qdv25', '41.143.187.214', 1517047310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034373331303b),
('sid7kjnrjbo46ba3ltnuscu36hc19b77', '94.234.38.153', 1516968246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383234363b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('siu4k2gdm999428c1hs0h6iqro5v0b5s', '90.224.199.144', 1516994344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343334343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2247374b35223b),
('sj78csqpfrs4ag929pqse24j93enqmio', '195.110.34.50', 1517054462, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343436323b),
('sk2vclgcb7i03gq9eldkfsrepvnhhlgm', '105.71.136.97', 1516910814, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931303831343b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2242345738223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b),
('sk45csh1ua26k1vgqkb81vssp7n47e5m', '90.224.199.144', 1516993145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333134353b6261636b5f66726f6d5f757365725f6c6f67696e7c733a33363a226a6f62732f747261766f732d61622d6a6f62732d696e2d6e2e612d6c726172652d313136223b757365725f69647c733a333a22343236223b757365725f656d61696c7c733a31333a2272616d40676d61696c2e636f6d223b66697273745f6e616d657c733a383a227272727272727272223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f656d706c6f79657273223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22474145564b223b6c6173745f6e616d657c733a303a22223b),
('skumaen8ffsn1nlkdv8c81jkk50ri230', '195.110.34.50', 1516994870, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343837303b),
('soiqa2ip9dv7tfsdi8mos52pqnjrv2g8', '66.249.66.200', 1516885764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363838353736343b),
('sonoi6519acd8g8aj63s5m6c4a0ci2i5', '66.249.66.19', 1516903968, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333936383b),
('sp1ugspmj02nn08p4nlj09j7ssjd4ejd', '108.171.101.195', 1517049259, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393235393b),
('ss77ekrondmkq3ev5um7o16ja6cshjjv', '41.143.187.214', 1517054163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343136333b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('staqj9un3l7sdrnvp4at1vmperq61ucq', '185.118.27.136', 1517058873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035383837333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32343a2263616e6469646174652f3632353934363566336434393466223b6d73677c733a35373a22506c65617365206c6f67696e206173206120656d706c6f79657220746f2076696577207468652063616e6469646174652070726f66696c652e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d),
('suc89q0u8epsvl6tos7ihc9rcrrmrvqe', '90.224.199.144', 1516901596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313539363b757365725f69647c733a323a223134223b75736572656d61696c7c733a303a22223b69735f757365725f6c6f67696e7c623a313b736c75677c733a31313a227863762d636f6d70616e79223b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b757365725f656d61696c7c733a31353a2274657374313840746573742e636f6d223b66697273745f6e616d657c733a343a224d61726b223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b637074636f64657c733a343a2258334644223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a32343a2261646d696e2f656d706c6f796572732f6c6f67696e2f3134223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('sup9imsbi2tsu6pb237rtkv3bdau4njn', '41.142.0.106', 1516895274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839353133333b636170576f72647c733a353a22503248444d223b),
('t0nj1valitsffhp8aunpnc0omriltc5f', '83.183.12.57', 1516995433, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353433333b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a303a22223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b69735f757365725f6c6f67696e7c623a303b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b736c75677c733a303a22223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a224e325735223b),
('t1elk1guinng380o08a9hpusk25qks8p', '195.110.34.50', 1516993867, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333836373b),
('t22ihhbed0ju7ddr105kc2o84i8ss9ic', '195.110.34.50', 1516994546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343534363b),
('t5pj09bm9bho64o7p6ic44j3j17oiu75', '195.110.34.50', 1517054526, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343532363b),
('t5tn44ga4k3fpih6vchqgcq365lqhdd7', '201.238.154.92', 1516973038, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937333033383b),
('t6u56eq62u1j0ng4alol2ro0nksojva7', '66.249.64.200', 1516962998, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936323939383b),
('t9lp4vkas51m67804h35176n0i1fuor2', '85.225.194.156', 1516981410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313431303b636170576f72647c733a353a224a4e314459223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b),
('tc2b8t4tca4g1c2ukqfuqta7g5kol02f', '90.224.199.144', 1516898297, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839383239373b636170576f72647c733a353a22515a325a42223b757365725f69647c693a3230393b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a224e325735223b74696d6573746d7c733a383a2231303a33363a3433223b),
('td5jm8u10v48ao0jbilrm69kd1gsooor', '90.224.199.144', 1516897783, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373738333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f6164645f736b696c6c73223b),
('teebt3qtahqtm4hmv0p0aqi92b5liqfp', '90.224.199.144', 1516994663, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939343636333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2258334644223b),
('tef55tu0p6tlofd6hrp5np0l052v5549', '83.183.12.57', 1516993821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333832313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22343237223b757365725f656d61696c7c733a31333a2273666940747261766f732e7365223b66697273745f6e616d657c733a353a2254696d2053223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31343a226a6f627365656b65722f63686174223b736c75677c733a31333a226d616c6d2d74696e6773727474223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22595a444353223b6c6173745f6e616d657c733a303a22223b637074636f64657c733a343a2247374b35223b),
('tf76if3im2s4lq3cpss3kqos3dqmd85b', '195.110.34.50', 1516995048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353034383b),
('tfs7cid1h15v8rcap551dvv7en8u3f2l', '41.143.187.214', 1517049688, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034393638383b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32303a226a6f627365656b65722f63765f6d616e61676572223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('ti2gei9s98nodp0vrh2vulksa6iepate', '66.249.93.75', 1517054179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343137383b637074636f64657c733a343a2242345738223b),
('ti9eimej8qg36na54hn3j27n31saq89u', '41.143.187.214', 1517044739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034343733393b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b),
('tied8qmb139brsff6g1rkdluo48cmd71', '195.110.34.50', 1516959288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393238383b),
('tjbp5h8uipf2pphla6mbffb9pch9m6bj', '195.110.34.50', 1517054164, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343136343b),
('tni6iiaq1q4vnimaqjdavgtqkti5hba8', '195.110.34.50', 1516995291, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353239313b),
('tp4hphjnu757psk14hqi0bcfmlaro8pv', '158.174.4.45', 1516917248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373234383b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a393a22747261766f732d6162223b637074636f64657c733a343a2242345738223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b),
('tpheaive8p5pco0biodsf73eutpi49j1', '66.249.66.21', 1517026419, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032363431393b),
('trnufcj8baf00rjh6bd61ntvni8261t6', '195.110.34.50', 1517004537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343533373b),
('tsu995oauiv4ggle32irv6o77t2gluam', '90.224.199.144', 1516995060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353036303b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b),
('tu1rgvtr0v50biu344chk6fohuqqhrev', '195.110.34.50', 1516992700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939323730303b),
('u1mrgpv4i57puhg80j5a8nigru3fpv58', '83.185.94.42', 1517058956, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035383935363b),
('u2v2do8h87fhkjrlhl507t4t9usdjaia', '83.185.94.42', 1517060034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303033343b),
('u3549832dj6s747mkbtp0eidk86cd4rc', '41.142.0.106', 1516902273, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930323237333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a224e325735223b),
('u4gohf95crf7s4fla9k8oqro12pb6vk2', '66.249.64.204', 1516965694, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936353639343b),
('u5j51nhrqt95epd2ncsgk1mb8td3dgj1', '195.110.34.50', 1517054341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343334313b),
('u8tp5u6vo4hdg01bpch1lhh45lk8tg2p', '105.156.230.57', 1516961349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936313334393b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a32333a22656d706c6f7965722f6d795f706f737465645f6a6f6273223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2247374b35223b),
('uadvnjtceldimlhrkueek578cirn72cs', '114.143.167.198', 1516953203, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935333230333b),
('ucej2kfjmu7jgh3vam9lrs7nevdknf1q', '158.174.4.45', 1516917642, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931373536313b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b757365725f69647c733a333a22323130223b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b736c75677c733a393a22747261766f732d6162223b637074636f64657c733a343a2242345738223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b636170576f72647c733a353a2247464d4656223b),
('ue8k1pqh9idkeb36fhhddaqi3jcfh54n', '66.249.93.77', 1517043866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034333836363b637074636f64657c733a343a2258334644223b),
('ueloihnq4ejg67u45np7b74k2sn2kj44', '195.110.34.50', 1517005282, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353238323b),
('uf8ug9bbnle8t5pvnfqlp7vhkb6eubkn', '195.110.34.50', 1517005165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030353136353b),
('uft2r8r3sojkqkec0kbmqs60cmpqo0lq', '90.224.199.144', 1516900860, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930303832353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31393a226a6f627365656b65722f64617368626f617264223b75736572656d61696c7c733a303a22223b636170576f72647c733a353a22444b4c5442223b6c6173745f6e616d657c733a303a22223b6261636b5f66726f6d5f61646d696e5f6c6f67696e7c733a31353a2261646d696e2f64617368626f617264223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b637074636f64657c733a343a2247374b35223b),
('ugh9o7bkc7tm1flvbbaf6rafhlu2385v', '195.110.34.50', 1517004507, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030343530373b),
('uj1b56bhofu268293b1s3ambg621arpf', '83.185.94.42', 1517060122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303132323b),
('ujfrtko80tao1md153bbr3vob9qn6hnr', '66.249.66.157', 1517021898, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032313839383b),
('ujn6ve46root25mmmgeqhv98cq7q9pbi', '177.75.221.75', 1516985820, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938353832303b),
('ulbjlm6ioiro7srecm77go92ddfcq31m', '159.192.221.98', 1517028881, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373032383838313b),
('uldaiaq6g049hc5p19dde1h8oqfpt5vu', '115.146.90.196', 1516901446, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313434363b),
('undvl4vaphan12a84m0d38vk5refu5ug', '195.110.34.50', 1516959076, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935393037363b),
('uq4nhqa3ja4e6mv21v7od5n06aljv7lu', '169.60.28.106', 1517054498, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439383b637074636f64657c733a343a224e325735223b),
('uq5f6ipn5npd78e5ii7hto90tsuiico5', '220.191.255.146', 1517045896, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373034353839363b),
('uq6s9me449ksjml1mfqf4rrgdsg8meif', '66.249.64.200', 1516940593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363934303539333b),
('urvlsqtdbhvdb7gtq6qkbii2jtk63uc5', '41.142.0.106', 1516896474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839363437343b),
('v0p1m0fvsn3gslvp211odlust73k3eh4', '85.225.194.156', 1516981108, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938313130383b636170576f72647c733a353a224a4e314459223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('v14b0t70t24qpc9p59p2rp0aqdk88geh', '217.196.250.88', 1516953236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363935333233363b),
('v3fqhhd9nmv3jpk171lsv3k70mhcoqhu', '90.224.199.144', 1516904042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930343034323b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231313a30353a3234223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('v3n03uv7529uevfosqacob77ojbeb80q', '66.249.66.21', 1517010606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373031303630363b),
('v3rcgccar0f4hblsb77abtmq6bknmam9', '105.156.230.57', 1516960064, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936303036343b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31333a227465737440746573742e636f6d223b66697273745f6e616d657c733a383a224a686f6e20446f65223b736c75677c733a31373a226d6567612d746563686e6f6c6f67696573223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b637074636f64657c733a343a2242345738223b),
('v50pcede9lh82i6tp66qg938frkdmpou', '178.73.215.171', 1516877008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837373030383b),
('v72u8vukgsj5tgip5me64r9vf1a27skt', '90.224.199.144', 1516901231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930313233313b636170576f72647c733a353a22515a325a42223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b74696d6573746d7c733a383a2231313a30353a3234223b75736572656d61696c7c733a303a22223b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('v7uaj0d69hc1lb8eu7tdlcq0oa85aqra', '85.225.194.156', 1516980967, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938303936373b6261636b5f66726f6d5f757365725f6c6f67696e7c733a31383a22656d706c6f7965722f64617368626f617264223b757365725f69647c733a333a22343233223b757365725f656d61696c7c733a31393a226d61696c72616d7a6940676d61696c2e636f6d223b66697273745f6e616d657c733a333a2252616d223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b),
('vacfhpp0gtshje3odnj03s8cqhau0eb1', '195.110.34.50', 1517060124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373036303132343b),
('vaj7dm6sqhae5lfibulpjdknrvta38hm', '178.79.181.200', 1516963793, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936333739333b),
('vct469n9ptn5989fmsa85hs0sqoqqkke', '66.249.66.19', 1516903964, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930333936343b637074636f64657c733a343a2254394c34223b),
('vfv8kgheuvqgftpsev3nmk1ggf2ea05k', '195.110.34.50', 1516999239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939393233393b),
('vgeqsbt6nh6ur39n2rm16u8rf126d120', '66.249.66.19', 1516873678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363837333637383b),
('vgqs96pm4r3fuvfc7or0o41m0fq0reue', '105.71.136.97', 1516912037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363931323033373b636170576f72647c733a353a225538564635223b757365725f69647c693a3231303b757365725f656d61696c7c733a32333a2261796f75622e657a7a696e693340676d61696c2e636f6d223b66697273745f6e616d657c733a31323a2241796f756220457a7a696e69223b736c75677c733a373a2265676f2d646576223b6c6173745f6e616d657c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b637074636f64657c733a343a2258334644223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('vh122a1u3lbvu53b752dba2e4g3m4h4d', '195.110.34.50', 1516996917, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363931373b);
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('vjhka5u6ab1i7mn31rljjot44at0hv60', '105.71.128.223', 1516995634, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939353632353b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('vjrikln77gt2oho4j8rj9jl06526ghhk', '85.225.194.156', 1516979211, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363937393231313b636170576f72647c733a353a224a4e314459223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b),
('vkq7pso3uh6detiokblbp6m3tu7ggvoi', '185.118.27.136', 1516897941, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363839373934313b636170576f72647c733a353a225554593438223b757365725f69647c693a3431313b757365725f656d61696c7c733a32353a2268617373616e61796f7562383540686f746d61696c2e636f6d223b66697273745f6e616d657c733a383a226766676667666868223b736c75677c733a303a22223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b6c6173745f6e616d657c733a303a22223b),
('vl5imp9717tdgpr84888r03eeshk33m3', '195.110.34.50', 1516989626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938393632363b),
('vlur96ktpdo29n2cpt24pabuc8bsli1k', '195.110.34.50', 1517054496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035343439363b),
('vm0dhhj6gt06e35n2ecl41pq8pdcjuu0', '185.118.27.136', 1516993515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939333531353b),
('vn7quf95pu3de60vtjnpqora48i8rlrj', '195.110.34.50', 1516996893, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363839333b),
('vr6ql8i457k5oi9mofre6gl7gsdmc8tp', '41.142.0.106', 1516902863, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363930323836333b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a323a223130223b757365725f656d61696c7c733a31343a22657465737440746573742e636f6d223b66697273745f6e616d657c733a393a224a686f6e79204d616e223b736c75677c4e3b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a313b69735f656d706c6f7965727c623a303b637074636f64657c733a343a2247374b35223b),
('vrnpijjcu6nl318f8t6v4hlkgajnfnbs', '66.249.64.200', 1516983800, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363938333830303b),
('vt8olr25n6svogr91hkgm6geghmo3e90', '94.234.38.153', 1516968213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363936383231333b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b),
('vtaaem69vaho35c3ic405ou238rnm0bs', '195.110.34.50', 1517000671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373030303637313b),
('vu1i4nmeoq2v92g4pbude2fh8rlkj4g6', '90.224.199.144', 1516996109, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363939363130393b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b74696d6573746d7c733a383a2231313a34383a3132223b637074636f64657c733a343a2258334644223b75736572656d61696c7c733a303a22223b),
('vu5fsvfpi3vq4nbqjldf9nrb8nks4tg8', '41.143.187.214', 1517052258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531373035323235383b637074636f64657c733a343a2242345738223b636170576f72647c733a353a225637425151223b757365725f69647c733a333a22323039223b757365725f656d61696c7c733a31393a226269786d617465636840676d61696c2e636f6d223b66697273745f6e616d657c733a353a224269786d61223b736c75677c733a353a226269786d61223b69735f757365725f6c6f67696e7c623a313b69735f6a6f625f7365656b65727c623a303b69735f656d706c6f7965727c623a313b6261636b5f66726f6d5f757365725f6c6f67696e7c733a303a22223b75736572656d61696c7c733a303a22223b61646d696e5f69647c733a313a2231223b6e616d657c733a353a2261646d696e223b69735f61646d696e5f6c6f67696e7c623a313b6d73677c733a3136373a223c64697620636c6173733d22616c65727420616c6572742d73756363657373223e3c6120687265663d22232220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c657274223e2674696d65733b3c2f613e3c7374726f6e673e53756363657373213c2f7374726f6e673e204a6f622041647665727469736520686173206265656e2075706461746564207375636365737366756c6c792e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `ID` int(11) NOT NULL,
  `emails_per_hour` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_settings`
--

INSERT INTO `tbl_settings` (`ID`, `emails_per_hour`) VALUES
(1, 300);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_skills`
--

CREATE TABLE `tbl_skills` (
  `ID` int(11) NOT NULL,
  `skill_name` varchar(40) DEFAULT NULL,
  `industry_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
ALTER TABLE `tbl_post_jobs` ADD FULLTEXT KEY `job_search` (`job_title`,`job_description`);

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
ALTER TABLE `tbl_seeker_additional_info` ADD FULLTEXT KEY `resume_search` (`summary`,`keywords`);

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
ALTER TABLE `tbl_seeker_skills` ADD FULLTEXT KEY `js_skill_search` (`skill_name`);

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
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `tbl_ad_codes`
--
ALTER TABLE `tbl_ad_codes`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `tbl_cms`
--
ALTER TABLE `tbl_cms`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT pour la table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  MODIFY `id_conversation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `tbl_conv_message`
--
ALTER TABLE `tbl_conv_message`
  MODIFY `id_conv_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `tbl_email_content`
--
ALTER TABLE `tbl_email_content`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `tbl_employers`
--
ALTER TABLE `tbl_employers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `tbl_institute`
--
ALTER TABLE `tbl_institute`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `tbl_job_seekers`
--
ALTER TABLE `tbl_job_seekers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;
--
-- AUTO_INCREMENT pour la table `tbl_job_titles`
--
ALTER TABLE `tbl_job_titles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tbl_post_jobs`
--
ALTER TABLE `tbl_post_jobs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT pour la table `tbl_prohibited_keywords`
--
ALTER TABLE `tbl_prohibited_keywords`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `tbl_qualifications`
--
ALTER TABLE `tbl_qualifications`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `tbl_scam`
--
ALTER TABLE `tbl_scam`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_academic`
--
ALTER TABLE `tbl_seeker_academic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_additional_info`
--
ALTER TABLE `tbl_seeker_additional_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_applied_for_job`
--
ALTER TABLE `tbl_seeker_applied_for_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_experience`
--
ALTER TABLE `tbl_seeker_experience`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_resumes`
--
ALTER TABLE `tbl_seeker_resumes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;
--
-- AUTO_INCREMENT pour la table `tbl_seeker_skills`
--
ALTER TABLE `tbl_seeker_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;
--
-- AUTO_INCREMENT pour la table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `tbl_stories`
--
ALTER TABLE `tbl_stories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
