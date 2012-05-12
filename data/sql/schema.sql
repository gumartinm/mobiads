CREATE TABLE ad (id BIGSERIAL, company_id BIGINT NOT NULL, company_categ_id BIGINT, ad_mobile_image_link VARCHAR(3000) NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE ad_description (id BIGSERIAL, language_id BIGINT NOT NULL, ad_id BIGINT NOT NULL, ad_name VARCHAR(255) NOT NULL, ad_description text, ad_mobile_text VARCHAR(500) NOT NULL, ad_link VARCHAR(3000) NOT NULL, PRIMARY KEY(id));
CREATE TABLE city (id BIGSERIAL, city_name VARCHAR(64) NOT NULL, region_id BIGINT NOT NULL, PRIMARY KEY(id));
CREATE TABLE company (id BIGSERIAL, user_id INT NOT NULL, company_cif VARCHAR(255) NOT NULL UNIQUE, PRIMARY KEY(id));
CREATE TABLE company_category (id BIGSERIAL, company_id BIGINT NOT NULL, general_categ_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, root_id BIGINT, lft INT, rgt INT, level SMALLINT, PRIMARY KEY(id));
CREATE TABLE company_category_description (id BIGSERIAL, language_id BIGINT NOT NULL, company_categ_id BIGINT NOT NULL, company_categ_name VARCHAR(255) NOT NULL, company_categ_description text, PRIMARY KEY(id));
CREATE TABLE company_description (id BIGSERIAL, company_id BIGINT NOT NULL, language_id BIGINT NOT NULL, company_name VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE country (id BIGSERIAL, country_name VARCHAR(80) NOT NULL, iso_code_2 VARCHAR(2) NOT NULL, iso_code_3 VARCHAR(3) NOT NULL, PRIMARY KEY(id));
CREATE TABLE general_category (id BIGSERIAL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, root_id BIGINT, lft INT, rgt INT, level SMALLINT, PRIMARY KEY(id));
CREATE TABLE general_category_description (id BIGSERIAL, language_id BIGINT NOT NULL, general_categ_id BIGINT NOT NULL, general_categ_name VARCHAR(255) NOT NULL UNIQUE, general_categ_description text, PRIMARY KEY(id));
CREATE TABLE language (id BIGSERIAL, language_name VARCHAR(255) NOT NULL UNIQUE, code VARCHAR(3) NOT NULL UNIQUE, PRIMARY KEY(id));
CREATE TABLE office (id BIGSERIAL, company_id BIGINT NOT NULL, city_id BIGINT, office_gps BYTEA, office_street_address VARCHAR(255) NOT NULL, office_zip VARCHAR(32) NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE office_ads (id BIGSERIAL, office_id INT NOT NULL, ad_id BIGINT NOT NULL, PRIMARY KEY(id));
CREATE TABLE region (id BIGSERIAL, country_id BIGINT NOT NULL, region_name VARCHAR(64) NOT NULL, PRIMARY KEY(id));
CREATE TABLE user_basket (id BIGSERIAL, user_id INT NOT NULL, general_categ_id BIGINT NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_forgot_password (id BIGSERIAL, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at TIMESTAMP NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_group (id BIGSERIAL, name VARCHAR(255) UNIQUE, description VARCHAR(1000), created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(group_id, permission_id));
CREATE TABLE sf_guard_permission (id BIGSERIAL, name VARCHAR(255) UNIQUE, description VARCHAR(1000), created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_remember_key (id BIGSERIAL, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_user (id BIGSERIAL, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active BOOLEAN DEFAULT 'true', is_super_admin BOOLEAN DEFAULT 'false', last_login TIMESTAMP, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(id));
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(user_id, group_id));
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(user_id, permission_id));
CREATE INDEX is_active_idx ON sf_guard_user (is_active);
ALTER TABLE ad ADD CONSTRAINT ad_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ad ADD CONSTRAINT ad_company_categ_id_company_category_id FOREIGN KEY (company_categ_id) REFERENCES company_category(id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ad_description ADD CONSTRAINT ad_description_language_id_language_id FOREIGN KEY (language_id) REFERENCES language(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ad_description ADD CONSTRAINT ad_description_ad_id_ad_id FOREIGN KEY (ad_id) REFERENCES ad(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE city ADD CONSTRAINT city_region_id_region_id FOREIGN KEY (region_id) REFERENCES region(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company ADD CONSTRAINT company_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_category ADD CONSTRAINT company_category_general_categ_id_general_category_id FOREIGN KEY (general_categ_id) REFERENCES general_category(id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_category ADD CONSTRAINT company_category_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_category_description ADD CONSTRAINT company_category_description_language_id_language_id FOREIGN KEY (language_id) REFERENCES language(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_category_description ADD CONSTRAINT ccci FOREIGN KEY (company_categ_id) REFERENCES company_category(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_description ADD CONSTRAINT company_description_language_id_language_id FOREIGN KEY (language_id) REFERENCES language(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE company_description ADD CONSTRAINT company_description_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE general_category_description ADD CONSTRAINT gggi FOREIGN KEY (general_categ_id) REFERENCES general_category(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE general_category_description ADD CONSTRAINT general_category_description_language_id_language_id FOREIGN KEY (language_id) REFERENCES language(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE office ADD CONSTRAINT office_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE office ADD CONSTRAINT office_city_id_city_id FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE office_ads ADD CONSTRAINT office_ads_office_id_office_id FOREIGN KEY (office_id) REFERENCES office(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE office_ads ADD CONSTRAINT office_ads_ad_id_ad_id FOREIGN KEY (ad_id) REFERENCES ad(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE region ADD CONSTRAINT region_country_id_country_id FOREIGN KEY (country_id) REFERENCES country(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE user_basket ADD CONSTRAINT user_basket_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE user_basket ADD CONSTRAINT user_basket_general_categ_id_general_category_id FOREIGN KEY (general_categ_id) REFERENCES general_category(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
