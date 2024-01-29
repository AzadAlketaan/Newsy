import PropTypes from 'prop-types';
// @mui
import { alpha, styled } from '@mui/material/styles';
import { Box, CardActionArea, Link, Card, Grid, Avatar, Typography, CardContent } from '@mui/material';
// utils
import { fDate } from '../../../utils/formatTime';
//
import SvgColor from '../../../components/svg-color';

// ----------------------------------------------------------------------

const StyledCardMedia = styled('div')({
  position: 'relative',
  paddingTop: 'calc(100% * 3 / 4)',
});

const StyledTitle = styled(Link)({
  height: 44,
  overflow: 'hidden',
  WebkitLineClamp: 2,
  display: '-webkit-box',
  WebkitBoxOrient: 'vertical',
});

const StyledAvatar = styled(Avatar)(({ theme }) => ({
  zIndex: 9,
  width: 32,
  height: 32,
  position: 'absolute',
  left: theme.spacing(3),
  bottom: theme.spacing(-2),
}));

const StyledInfo = styled('div')(({ theme }) => ({
  display: 'flex',
  flexWrap: 'wrap',
  justifyContent: 'flex-end',
  marginTop: theme.spacing(3),
  color: theme.palette.text.disabled,
}));

const StyledCover = styled('img')({
  top: 0,
  width: '100%',
  height: '100%',
  objectFit: 'image',
  position: 'absolute',
});

// ----------------------------------------------------------------------

ArticleCard.propTypes = {
  article: PropTypes.object.isRequired,
  index: PropTypes.number,
};

export default function ArticleCard({ article, index }) {
  const noImage = '/assets/No_Image_Available.jpg';
  const { image, title, url, content, source, author, createdAt } = article;
  const latestArticleLarge = index === 0;
  const latestArticle = index === 1 || index === 2;

  return (
    <Grid item xs={12} sm={latestArticleLarge ? 12 : 6} md={latestArticleLarge ? 6 : 3}>
      <Card sx={{ position: 'relative' }}>
        <CardActionArea
          component="a"
          href={url}
        >
          <StyledCardMedia
            sx={{
              ...((latestArticleLarge || latestArticle) && {
                pt: 'calc(100% * 4 / 3)',
                '&:after': {
                  top: 0,
                  content: "''",
                  width: '100%',
                  height: '100%',
                  position: 'absolute',
                  bgcolor: (theme) => alpha(theme.palette.grey[900], 0.72),
                },
              }),
              ...(latestArticleLarge && {
                pt: {
                  xs: 'calc(100% * 4 / 3)',
                  sm: 'calc(100% * 3 / 4.66)',
                },
              }),
            }}
          >
            <SvgColor
              color="paper"
              src="/assets/icons/shape-avatar.svg"
              sx={{
                width: 80,
                height: 36,
                zIndex: 9,
                bottom: -15,
                position: 'absolute',
                color: 'background.paper',
                ...((latestArticleLarge || latestArticle) && { display: 'none' }),
              }}
            />
            <StyledAvatar
              alt={source.name}
              src={source.name}
              sx={{
                ...((latestArticleLarge || latestArticle) && {
                  zIndex: 9,
                  top: 24,
                  left: 24,
                  width: 40,
                  height: 40,
                }),
              }}
            />

            <StyledCover alt={title} src={image ?? noImage}
              onError={(e) => {e.target.src = noImage; e.target.onError = null;}}
            />
          </StyledCardMedia>

          <CardContent
            src={url}
            sx={{
              pt: 4,
              ...((latestArticleLarge || latestArticle) && {
                bottom: 0,
                width: '100%',
                position: 'absolute',
              }),
            }}
          >
            <Typography gutterBottom variant="caption" sx={{ color: 'text.disabled', display: 'block' }}>
              {fDate(createdAt)}
            </Typography>

            <StyledTitle
              color="inherit"
              variant="subtitle2"
              underline="hover"
              sx={{
                ...(latestArticleLarge && { typography: 'h5', height: 60 }),
                ...((latestArticleLarge || latestArticle) && {
                  color: 'common.white',
                }),
              }}
            >
              {content ?? title}
            </StyledTitle>

            <StyledInfo>
                <Box
                  key={index}
                  sx={{
                    display: 'flex',
                    alignItems: 'center',
                    ml: index === 0 ? 0 : 1.5,
                    ...((latestArticleLarge || latestArticle) && {
                      color: 'grey.500',
                    }),
                  }}
                >
                <Typography variant="caption">{author?.name}</Typography>
                </Box>
            </StyledInfo>
          </CardContent>
        </CardActionArea>
      </Card>
    </Grid>
  );
}
